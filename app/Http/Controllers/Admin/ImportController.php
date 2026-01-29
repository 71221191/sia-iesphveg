<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Imports\CoursesImport;
use App\Imports\LegacyGradesImport;
use Illuminate\Support\Facades\DB;


class ImportController extends Controller
{
    // Función para importar Cursos
    public function importCourses(Request $request)
    {
        // 1. Validamos que realmente sea un archivo Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // 2. Creamos una instancia del importador para poder leer sus resultados después
        $importador = new CoursesImport;

        // 3. Ejecutamos la importación
        Excel::import($importador, $request->file('file'));

        // 4. Sacamos el resumen que preparamos en CoursesImport.php
        $resumen = $importador->reporte;

        // 5. Preparamos el mensaje que verás en la franja verde
        $mensaje = "¡Proceso terminado! " .
                   "Creados: {$resumen['creados']}, " .
                   "Actualizados/Duplicados: {$resumen['actualizados']}, " .
                   "Omitidos: {$resumen['omitidos']}.";

        // 6. Volvemos atrás mandando el mensaje de éxito y la lista de errores
        return back()
            ->with('success', $mensaje)
            ->with('detalles_errores', $resumen['errores']);
    }

    // Tu otra función de alumnos (la dejamos igual)
    public function importStudents(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new StudentsImport, $request->file('file'));
        return back()->with('success', 'Alumnos importados correctamente.');
    }

    public function importGrades(Request $request)
    {
        // Tiempo infinito para que PHP no corte la conexión mientras sube el archivo
        set_time_limit(0);

        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        $importId = $request->input('import_id');

        // Desactivamos el Log de consultas para no llenar la RAM
        DB::disableQueryLog();

        \Maatwebsite\Excel\Facades\Excel::queueImport(
            new \App\Imports\LegacyGradesImport($importId),
            $request->file('file')
        );

        return response()->json(['started' => true]);
    }

    public function importActiveStudents(Request $request)
    {
        ini_set('max_execution_time', 0); // 0 significa "sin límite de tiempo"
        set_time_limit(0);
        
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        $importId = uniqid();

        \Maatwebsite\Excel\Facades\Excel::import(
            new \App\Imports\ActiveStudentsImport($importId),
            $request->file('file')
        );

        $res = \App\Imports\ActiveStudentsImport::$reporte;

        return back()
            ->with('success', "¡Importación 2025 terminada! Creados: {$res['creados']}, Actualizados: {$res['actualizados']}.")
            ->with('detalles_errores', $res['errores'])
            ->with('detalles_actualizados', $res['actualizados_lista']); // <--- Enviamos la lista
    }
}
