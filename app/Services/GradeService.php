<?php

namespace App\Services;

use App\Models\Grade;
use App\Models\EnrollmentDetail;
use App\Models\CourseSection;
use App\Models\GradeScale;
use Illuminate\Support\Facades\DB;
use Exception;

class GradeService
{
    public function saveGrades(CourseSection $section, array $gradesData, $teacherId)
    {
        return DB::transaction(function () use ($section, $gradesData, $teacherId) {

            // 1. Validar acta cerrada
            if ($section->is_closed) {
                throw new Exception("El acta ya está cerrada y no se pueden modificar las notas.");
            }

            // 2. Traemos todas las escalas de una vez para no hacer mil consultas (Optimización)
            $scales = GradeScale::all()->pluck('numeric_equivalent', 'id');

            foreach ($gradesData as $studentData) {
                $detailId = $studentData['detail_id'];
                $finalNote = null;

                // --- ESCENARIO A: Evaluación por Competencias ---
                if ($section->course->evaluation_type === 'competency') {
                    $sum = 0;
                    $count = 0;

                    foreach ($studentData['competencies'] as $compData) {
                        // Solo guardamos si eligió una nota
                        if (!empty($compData['grade_scale_id'])) {
                            Grade::updateOrCreate(
                                ['enrollment_detail_id' => $detailId, 'competency_id' => $compData['competency_id']],
                                [
                                    'grade_scale_id' => $compData['grade_scale_id'],
                                    'registered_by' => $teacherId,
                                    'registered_at' => now(),
                                ]
                            );
                            $sum += $scales[$compData['grade_scale_id']] ?? 0;
                            $count++;
                        }
                        // SI ELIGIÓ EL "-" (VACÍO)
                        else {
                            // Borramos el registro si existía para que quede limpio
                            Grade::where('enrollment_detail_id', $detailId)
                                ->where('competency_id', $compData['competency_id'])
                                ->delete();
                        }
                    }

                    // Calculamos la nota vigesimal final si el alumno tiene notas
                    if ($count > 0) {
                        $average = $sum / $count;
                        $finalNote = $this->calculateVigesimal($average);
                    }
                }

                // --- ESCENARIO B: Evaluación Numérica (Legacy) ---
                else {
                    $finalNote = $studentData['final_score'];
                }

                // --- ACTUALIZACIÓN GLOBAL EN ENROLLMENT_DETAILS ---
                if ($finalNote !== null) {
                    $detail = EnrollmentDetail::findOrFail($detailId);
                    $detail->update([
                        'final_score_numeric' => $finalNote,
                        'status' => $finalNote >= 10.5 ? 'approved' : 'failed'
                    ]);
                }
            }

            return true;
        });
    }

    public function calculateVigesimal($average)
    {
        // Regla del 0.05 a favor: Si tiene 2.95, sube a 3.0
        $fraction = $average - floor($average);
        if ($fraction >= 0.949) { // Usamos 0.949 por precisión decimal
            $average = ceil($average);
        }

        // Tabla oficial MINEDU
        if ($average >= 1.0 && $average <= 1.1) return 1;
        if ($average <= 1.3) return 2;
        if ($average <= 1.5) return 3;
        if ($average <= 1.7) return 4;
        if ($average <= 1.9) return 5;
        if ($average <= 2.1) return 6;
        if ($average <= 2.3) return 7;
        if ($average <= 2.5) return 8;
        if ($average <= 2.7) return 9;
        if ($average <= 2.9) return 10;
        if ($average >= 3.0 && $average <= 3.2) return 11; // Mínima aprobatoria
        if ($average <= 3.5) return 12;
        if ($average <= 3.7) return 13;
        if ($average <= 3.9) return 14;
        if ($average <= 4.1) return 15;
        if ($average <= 4.3) return 16;
        if ($average <= 4.5) return 17;
        if ($average <= 4.7) return 18;
        if ($average <= 4.9) return 19;
        if ($average == 5.0) return 20;

        return 0;
    }
}
