<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\StudyPlan;
use App\Models\StudyProgram;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use App\Traits\StandardizesAcademicData; // Importamos el colador

class CoursesImport implements ToCollection, WithHeadingRow
{
    use StandardizesAcademicData; // Usamos el colador

    public $reporte = [
        'creados' => 0,
        'actualizados' => 0,
        'omitidos' => 0,
        'errores' => []
    ];

    /**
     * Limpiador agresivo para evitar duplicados por puntos, comas o espacios
     */
    private function limpiarTextoGeneral($texto)
    {
        $texto = strtoupper(trim($texto));
        // Quitamos los ":" que están causando los duplicados
        $texto = str_replace(':', '', $texto);
        // Convertimos múltiples espacios en uno solo
        $texto = preg_replace('/\s+/', ' ', $texto);
        return trim($texto);
    }

    private function normalizarResolucion($texto)
    {
        if (empty($texto)) return 'PLAN ANTIGUO';
        $texto = $this->limpiarTextoGeneral($texto);
        $buscar = ['RESOLUCIÓN VICEMINISTERIAL', 'RESOLUCION VICEMINISTERIAL', 'Nº', 'N°', 'MINEDU'];
        $reemplazar = ['RVM', 'RVM', '', '', 'MINEDU'];
        $texto = str_replace($buscar, $reemplazar, $texto);
        return trim($texto);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $filaNum = $index + 2;

            // 1. USAMOS EL COLADOR UNIVERSAL (Esto ya nos da programa y resolución limpios)
            $info = $this->extraerInfoPrograma($row['programa'] ?? '');

            try {
                if (empty($row['programa'])) {
                    $this->reporte['omitidos']++;
                    continue;
                }

                // 2. BUSCAR O CREAR EL PROGRAMA (Ya viene limpio del Trait)
                $program = StudyProgram::firstOrCreate([
                    'name' => $info['programa']
                ]);

                // 3. BUSCAR O CREAR EL PLAN (Ya viene limpio del Trait)
                $plan = StudyPlan::firstOrCreate(
                    [
                        'study_program_id' => $program->id,
                        'resolution_code' => $info['resolucion']
                    ],
                    [
                        'name' => 'Plan ' . $info['resolucion'],
                        'evaluation_type' => 'competency',
                        'valid_from_year' => 2019,
                        'is_active' => true
                    ]
                );

                // 4. PROCESAR EL CURSO
                $courseName = trim($row['curso'] ?? $row['nombre_del_curso'] ?? '');
                $ciclo = trim($row['ciclo'] ?? 'I');

                if (empty($courseName)) continue;

                $existe = Course::where('study_plan_id', $plan->id)
                                ->where('name', $courseName)
                                ->where('cycle', $ciclo)
                                ->first();

                if ($existe) $this->reporte['actualizados']++;
                else $this->reporte['creados']++;

                $course = Course::firstOrNew([
                    'study_plan_id' => $plan->id,
                    'name' => $courseName,
                    'cycle' => $ciclo
                ]);

                // Solo generamos código aleatorio si el curso NO existe
                if (!$course->exists) {
                    $course->code = mb_substr(Str::ascii($courseName), 0, 3, 'UTF-8') . rand(100, 999);
                }

                // Asignamos/Actualizamos el resto de valores
                $course->credits = is_numeric($row['creditos'] ?? 0) ? ($row['creditos'] ?? 0) : 0;
                $course->type = (str_contains(strtoupper($courseName), 'ELECTIVO')) ? 'elective' : 'specific';
                $course->is_legacy = ($info['resolucion'] == 'PLAN ANTIGUO');
                $course->save();
                // --- FIN DEL CAMBIO ---

            } catch (\Exception $e) {
                $this->reporte['errores'][] = "Fila {$filaNum}: Error -> " . $e->getMessage();
            }
        }
    }
}
