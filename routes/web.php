<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\SocioeconomicController;
use App\Http\Controllers\Admin\ImportController;
use App\Imports\StudentsImport;
use App\Imports\CoursesImport;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Admin\AcademicPeriodController;
use App\Http\Controllers\Admin\StudyProgramController;
use App\Http\Controllers\Admin\StudyPlanController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseSectionController;
use App\Http\Controllers\DashboardController;

// 1. RUTA DE BIENVENIDA (Landing Page)

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// 2. RUTAS PROTEGIDAS POR LOGIN
Route::middleware(['auth', 'verified'])->group(function () {

    // --- ZONA ALUMNO (Común) ---

    // Ficha Socioeconómica (El Cerrojo)
    Route::get('/ficha-socioeconomica', [SocioeconomicController::class, 'create'])->name('socioeconomic.create');
    Route::post('/ficha-socioeconomica', [SocioeconomicController::class, 'store'])->name('socioeconomic.store');

    // Rutas que requieren FICHA VALIDADA
    Route::middleware(['check.socioeconomic'])->group(function () {
        // Dashboard Alumno
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Matrícula
        Route::get('/matricula', [EnrollmentController::class, 'create'])->name('enrollment.create');
        Route::post('/matricula', [EnrollmentController::class, 'store'])->name('enrollment.store');
    });

    // --- ZONA ADMINISTRATIVA (Protegida) ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        // 1. Dashboard Admin
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard'); 
        })->name('dashboard');

        // 2. Gestión de Estudiantes
        Route::get('/estudiantes', [StudentController::class, 'index'])->name('students.index');
        Route::get('/estudiantes/{id}', [StudentController::class, 'show'])->name('students.show');

        // 3. MANTENEDORES (CRUDs Optimizados) 
        // Usamos 'parameters' para mantener compatibilidad con tus variables {academicPeriod}, etc.

        // Periodos
        Route::resource('periodos', AcademicPeriodController::class)
            ->names('academic_periods')
            ->parameters(['periodos' => 'academicPeriod']);
        Route::post('/periodos/{academicPeriod}/open', [AcademicPeriodController::class, 'openPeriod'])->name('academic_periods.open');

        // Programas (Carreras)
        Route::resource('programas', StudyProgramController::class)
            ->names('study_programs')
            ->parameters(['programas' => 'studyProgram']);

        // Planes de Estudio
        Route::resource('planes', StudyPlanController::class)
            ->names('study_plans')
            ->parameters(['planes' => 'studyPlan']);

        // Cursos
        Route::resource('cursos', CourseController::class)
            ->names('courses')
            ->parameters(['cursos' => 'course']);

        // Secciones
        Route::resource('secciones-cursos', CourseSectionController::class)
            ->names('course_sections')
            ->parameters(['secciones-cursos' => 'courseSection']);
    });

});

// 3. CONFIGURACIONES ADICIONALES (Profile, etc.)
require __DIR__.'/settings.php';


/*
|--------------------------------------------------------------------------
| SECCIÓN DE IMPORTACIÓN (ADMIN)
|--------------------------------------------------------------------------
*/

// --- RUTAS PARA ALUMNOS (Excel 1) ---
Route::post('/importar-alumnos', [ImportController::class, 'importStudents'])->name('import.students');

// Ruta temporal de prueba rápida para alumnos
Route::get('/test-import-alumnos', function () {
    ini_set('max_execution_time', 0);
    set_time_limit(0);
    // Cambia el nombre si tu archivo de alumnos se llama distinto en storage/app
    Excel::import(new StudentsImport, storage_path('app/alumnos.xlsx'));
    return "Importación de alumnos completada con éxito.";
});


// --- RUTAS PARA CURSOS (Excel 2) ---

// A. Ruta para MOSTRAR el formulario de subida
Route::get('/subir-cursos-test', function () {

    // Preparar el HTML de los errores si existen en la sesión
    $htmlErrores = '';
    if (session('detalles_errores') && count(session('detalles_errores')) > 0) {
        $htmlErrores = '
        <div style="color: #842029; background: #f8d7da; border: 1px solid #f5c2c7; padding: 15px; margin: 20px 0; font-family: sans-serif; border-radius: 5px;">
            <h3 style="margin-top:0">⚠️ Detalles encontrados durante la importación:</h3>
            <ul style="max-height: 250px; overflow-y: auto;">';
        foreach (session('detalles_errores') as $error) {
            $htmlErrores .= '<li>' . $error . '</li>';
        }
        $htmlErrores .= '</ul>
        </div>';
    }

    return '
        <div style="font-family: sans-serif; max-width: 800px; margin: 50px auto; padding: 30px; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <h1 style="color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px;">Importador de Cursos Académicos</h1>

            <!-- Mensaje de éxito -->
            '.(session('success') ? '
                <div style="color: #0f5132; background: #d1e7dd; border: 1px solid #badbcc; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                    '.session('success').'
                </div>
            ' : '').'

            <!-- Cuadro de errores -->
            ' . $htmlErrores . '

            <div style="background: #f8f9fa; padding: 25px; border-radius: 10px; border: 1px solid #e9ecef;">
                <p style="margin-top:0; color: #666;">Selecciona el archivo Excel de Cursos (Catálogo de 1,400 registros).</p>

                <form action="'.route('import.courses').'" method="POST" enctype="multipart/form-data">
                    '.csrf_field().'

                    <div style="margin-bottom: 20px;">
                        <input type="file" name="file" required style="font-size: 16px;">
                    </div>

                    <button type="submit" style="background: #198754; color: white; padding: 12px 25px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%;">
                        🚀 INICIAR IMPORTACIÓN DE CURSOS
                    </button>
                </form>
            </div>

            <div style="margin-top: 30px; font-size: 13px; color: #7f8c8d; line-height: 1.6;">
                <strong>Nota profesional:</strong>
                <ul style="margin-top: 5px;">
                    <li>El sistema detectará automáticamente los Planes con RVM mediante paréntesis.</li>
                    <li>Los cursos sin RVM se asignarán automáticamente al <strong>PLAN ANTIGUO</strong>.</li>
                    <li>El DNI se usará como llave única para evitar duplicar personas.</li>
                </ul>
            </div>
        </div>
    ';
});

// B. Ruta para PROCESAR el archivo de cursos (POST)
Route::post('/importar-cursos-proceso', [ImportController::class, 'importCourses'])->name('import.courses');

Route::post('/importar-alumnos-activos', [ImportController::class, 'importActiveStudents'])->name('import.active_students');

// RUTA POST
Route::post('/importar-notas-proceso', [ImportController::class, 'importGrades'])->name('import.grades');

// Ruta para que el navegador pregunte el progreso (AJAX)
Route::get('/import-status/{id}', function($id) {
    return response()->json([
        'current' => Cache::get("import_progress_{$id}", 0),
        'total' => Cache::get("import_total_{$id}", 0)
    ]);
});

// RUTA GET (Formulario)
// Vista con Barra de Progreso
Route::get('/subir-notas-historico', function () {
    $importId = uniqid(); // Generamos un ID único para esta subida
    return '
        <div style="font-family:sans-serif; max-width:600px; margin:50px auto; padding:30px; border:1px solid #ccc; border-radius:10px;">
            <h2>Importador con Progreso Real (14k)</h2>

            <form id="uploadForm" enctype="multipart/form-data">
                '.csrf_field().'
                <input type="hidden" name="import_id" value="'.$importId.'">
                <input type="file" name="file" id="fileInput" required><br><br>
                <button type="submit" id="btnSubir" style="background:#d35400; color:white; padding:10px 20px; border:none; cursor:pointer;">🚀 EMPEZAR IMPORTACIÓN</button>
            </form>

            <div id="progressContainer" style="display:none; margin-top:30px;">
                <p id="statusText">Procesando filas: <span id="current">0</span> de <span id="total">0</span></p>
                <div style="width:100%; background:#eee; height:25px; border-radius:15px; overflow:hidden;">
                    <div id="progressBar" style="width:0%; background:#27ae60; height:100%; transition:width 0.5s;"></div>
                </div>
                <p id="percentText" style="text-align:right; font-weight:bold;">0%</p>
            </div>
        </div>

        <script>
            const form = document.getElementById("uploadForm");
            form.onsubmit = async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                document.getElementById("btnSubir").disabled = true;
                document.getElementById("progressContainer").style.display = "block";

                // Enviar archivo
                fetch("'.route('import.grades').'", { method: "POST", body: formData });

                // Empezar a preguntar el progreso cada 2 segundos
                const interval = setInterval(async () => {
                    const res = await fetch("/import-status/'.$importId.'");
                    const data = await res.json();

                    if (data.current === "COMPLETO") {
                        document.getElementById("progressBar").style.width = "100%";
                        document.getElementById("percentText").innerText = "¡COMPLETO!";
                        clearInterval(interval);
                        alert("Importación finalizada con éxito.");
                    } else if (data.total > 0) {
                        const percent = Math.round((data.current / data.total) * 100);
                        document.getElementById("current").innerText = data.current;
                        document.getElementById("total").innerText = data.total;
                        document.getElementById("progressBar").style.width = percent + "%";
                        document.getElementById("percentText").innerText = percent + "%";
                    }
                }, 2000);
            };
        </script>
    ';
});

Route::get('/subir-alumnos-2025', function () {
    $listaErrores = '';
    if (session('detalles_errores')) {
        $listaErrores = '<div style="color:red; background:#fff1f0; border:1px solid red; padding:15px; margin:20px 0;"><h3>Errores:</h3><ul>';
        foreach (session('detalles_errores') as $error) { $listaErrores .= '<li>'.$error.'</li>'; }
        $listaErrores .= '</ul></div>';
    }

    // --- NUEVO: LISTA DE ACTUALIZADOS ---
    $listaActualizados = '';
    if (session('detalles_actualizados')) {
        $listaActualizados = '
        <div style="color:#055160; background:#cff4fc; border:1px solid #b6effb; padding:15px; margin:20px 0; max-height:200px; overflow-y:auto;">
            <h3 style="margin-top:0">📋 Lista de Alumnos Actualizados:</h3>
            <ul style="font-size:12px;">';
        foreach (session('detalles_actualizados') as $alumno) {
            $listaActualizados .= '<li>'.$alumno.'</li>';
        }
        $listaActualizados .= '</ul></div>';
    }
    // ------------------------------------

    return '
        <div style="font-family:sans-serif; max-width:800px; margin:40px auto; padding:30px; border:1px solid #eee; border-radius:10px;">
            <h1 style="color:#2c3e50;">Pestaña 3: Importar Alumnos Actuales (2025)</h1>
            '.(session('success') ? '<div style="background:#d1e7dd; color:#0f5132; padding:15px; margin-bottom:20px;">'.session('success').'</div>' : '').'

            '.$listaErrores.'
            '.$listaActualizados.' <!-- AQUÍ SE MUESTRA LA LISTA -->

            <form action="'.route('import.active_students').'" method="POST" enctype="multipart/form-data">
                '.csrf_field().'
                <p>Selecciona el Excel que contiene los datos socioeconómicos y de matrícula 2025:</p>
                <input type="file" name="file" required><br><br>
                <button type="submit" style="background:#2980b9; color:white; padding:12px 25px; border:none; cursor:pointer; font-weight:bold;">
                    🚀 PROCESAR ALUMNOS 2025
                </button>
            </form>
        </div>
    ';
});
