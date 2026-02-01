<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Person;
use App\Models\GradeScale;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\NumberHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AttendanceService;

class SectionController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    
    /**
     * Listado de cursos asignados al docente
     */
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->person;

        if (!$teacher) {
            abort(404, "Este usuario no tiene un perfil de docente asignado.");
        }

        $sections = CourseSection::with(['course'])
            ->where('teacher_id', $teacher->id)
            ->whereHas('academicPeriod', function($q) {
                $q->where('status', 'open');
            })
            ->get();

        return Inertia::render('Teacher/Sections/Index', [
            'sections' => $sections
        ]);
    }

    /**
     * La "Sábana de Notas" de una sección específica
     */
    public function show(CourseSection $section)
    {
        // 1. Seguridad: Verificar que sea SU sección
        $teacher = Person::where('user_id', Auth::id())->firstOrFail();
        if ($section->teacher_id !== $teacher->id) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        // 2. Cargar el curso con sus competencias (si es por competencias)
        $section->load(['course.competencies', 'academicPeriod']);

        // 3. Cargar los alumnos matriculados con sus notas actuales
        $students = $section->enrollmentDetails()
            ->with(['enrollment.person', 'grades'])
            ->get()
            ->map(function($detail) {
                return [
                    'detail_id' => $detail->id,
                    'student_name' => $detail->enrollment->person->last_name_p . ' ' . $detail->enrollment->person->names,
                    'grades' => $detail->grades, // Notas por competencia
                    'final_score' => $detail->final_score_numeric, // Nota vigesimal
                ];
            });

        $attendanceStats = $this->attendanceService->getAttendanceWarning($section);
        // 4. Cargar escala de notas (Logrado, Proceso, etc.) para los combos
        $gradeScales = GradeScale::all();

        $isSyllabusApproved = $section->portfolios()
            ->where('type', 'syllabus')
            ->where('status', 'approved')
            ->exists();

        return Inertia::render('Teacher/Sections/Show', [
            'section' => $section->load(['course.competencies', 'academicPeriod']),
            'students' => $students,
            'attendanceStats' => $attendanceStats, // <--- Enviamos esto a Vue
            'gradeScales' => GradeScale::all(),
            'evaluationType' => $section->course->evaluation_type,
            'isSyllabusApproved' => $isSyllabusApproved,
            'gradeScales' => $gradeScales
        ]);
    }

    public function close(CourseSection $section)
    {
        // 1. Seguridad: Solo el docente asignado puede cerrar
        $teacher = Person::where('user_id', Auth::id())->firstOrFail();
        if ($section->teacher_id !== $teacher->id) {
            abort(403);
        }

        // 2. Validación: No se puede cerrar si faltan alumnos por calificar
        // (Verificamos que todos tengan nota final calculada)
        $faltantes = $section->enrollmentDetails()->whereNull('final_score_numeric')->count();
        if ($faltantes > 0) {
            return back()->withErrors(['error' => "No puedes cerrar el acta. Faltan calificar {$faltantes} alumnos."]);
        }

        // 3. Proceso de Cierre
        $section->update([
            'is_closed' => true,
            'acta_close_date' => now(),
            'acta_number' => 'ACTA-' . now()->format('Y') . '-' . str_pad($section->id, 4, '0', STR_PAD_LEFT)
        ]);

        return back()->with('success', 'Acta cerrada y oficializada correctamente.');
    }

    public function configure(CourseSection $section)
    {
        // Traemos todas las competencias agrupadas por su dominio para que el profe elija
        $catalog = \App\Models\Competency::with('domain')->get();

        // Traemos las que ya tenga seleccionadas actualmente
        $selectedIds = $section->course->competencies->pluck('id')->toArray();

        return Inertia::render('Teacher/Sections/Configure', [
            'section' => $section->load('course'),
            'catalog' => $catalog,
            'selectedIds' => $selectedIds
        ]);
    }

    public function setCompetencies(Request $request, CourseSection $section)
    {
        $request->validate([
            'competencies' => 'required|array|min:1',
            'competencies.*' => 'exists:competencies,id'
        ]);

        // Sincronizamos en la tabla pivote course_competency
        // El método sync() borra lo anterior y pone lo nuevo (limpio y seguro)
        $section->course->competencies()->sync($request->competencies);

        return redirect()->route('teacher.sections.show', $section->id)
            ->with('success', 'Competencias configuradas. Ya puedes registrar notas.');
    }

    public function pdf(CourseSection $section)
    {
        // 1. Cargar toda la data necesaria
        $section->load(['course.competencies', 'academicPeriod', 'teacher']);

        $students = $section->enrollmentDetails()
            ->with(['enrollment.person', 'grades.gradeScale'])
            ->get()
            ->map(function($detail) {
                return [
                    'name' => $detail->enrollment->person->last_name_p . ' ' . $detail->enrollment->person->last_name_m . ', ' . $detail->enrollment->person->names,
                    'dni' => $detail->enrollment->person->dni,
                    'grades' => $detail->grades->pluck('gradeScale.numeric_equivalent', 'competency_id'),
                    'final_score' => $detail->final_score_numeric,
                ];
            });

        // 2. Preparar Logos (Base64 para velocidad)
        $logoMinedu = $this->convertImageToBase64(public_path('img/logo-minedu.png'));
        $logoInsti = $this->convertImageToBase64(public_path('img/logo-instituto.png'));

        // 3. Generar PDF
        $pdf = Pdf::loadView('reports.acta', [
            'section' => $section,
            'students' => $students,
            'logoMinedu' => $logoMinedu,
            'logoInsti' => $logoInsti,
            'numberHelper' => new NumberHelper()
        ]);

        // El acta suele ser mejor en Horizontal (Landscape) si hay muchas competencias
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream("Acta_{$section->acta_number}.pdf");
    }

    // Asegúrate de tener este helper también si no lo pusiste en este controlador
    private function convertImageToBase64($path) {
        if (!file_exists($path)) return null;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
