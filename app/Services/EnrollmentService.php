<?php

namespace App\Services;

use App\Models\User;
use App\Models\Person;
use App\Models\Enrollment;
use App\Models\AcademicPeriod;
use App\Models\CourseSection;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Exception;

class EnrollmentService
{
    public function registerEnrollment(User $user, array $sectionIds)
    {
        return DB::transaction(function () use ($user, $sectionIds) {

            // 1. Datos Base
            $person = Person::where('user_id', $user->id)->firstOrFail();
            $period = AcademicPeriod::where('status', 'open')->firstOrFail();

            // --- TU LÓGICA DE PRERREQUISITOS (INTEGRADA AQUÍ) ---
            // Obtenemos los IDs de los cursos que el alumno YA aprobó en el pasado
            $approvedCourseIds = DB::table('enrollment_details')
                ->join('enrollments', 'enrollment_details.enrollment_id', '=', 'enrollments.id')
                ->where('enrollments.person_id', $person->id)
                ->where('enrollment_details.status', 'approved')
                ->pluck('enrollment_details.course_id')
                ->toArray();
            // ----------------------------------------------------

            // 2. BUSCAR O CREAR LA CABECERA (Solo una por alumno/periodo)
            $enrollment = Enrollment::firstOrCreate(
                [
                    'person_id' => $person->id,
                    'academic_period_id' => $period->id,
                ],
                [
                    'study_plan_id' => 1, // OJO: Idealmente sacar del alumno ($person->study_plan_id)
                    'cycle' => 'I',
                    'enrollment_type_id' => 1,
                    'shift_id' => 1,
                    'section_label' => 'A',
                    'created_at' => now(),
                ]
            );

            // 3. PROCESAR CADA CURSO (Detalles)
            foreach ($sectionIds as $sectionId) {

                // --- BLOQUEO DE BASE DE DATOS (Anti-Overbooking) ---
                $section = CourseSection::lockForUpdate()->with('course.prerequisites')->find($sectionId);

                if (!$section) throw new Exception("Una sección seleccionada ya no existe.");

                // A. Validación: Vacantes
                if ($section->vacancy_limit <= 0) {
                    throw new Exception("El curso '{$section->name}' se acaba de llenar. Intenta con otra sección.");
                }

                // B. Validación: Prerrequisitos (TU LÓGICA)
                foreach ($section->course->prerequisites as $prereq) {
                    if (!in_array($prereq->prerequisite_course_id, $approvedCourseIds)) {
                        $nombreRequerido = Course::find($prereq->prerequisite_course_id)->name ?? 'Desconocido';
                        throw new Exception("No puedes matricularte en '{$section->course->name}'. Debes aprobar antes: {$nombreRequerido}.");
                    }
                }

                // C. Validación: No duplicar curso (Si ya lo tiene en detalles)
                $exists = $enrollment->details()->where('course_section_id', $section->id)->exists();
                if ($exists) continue; // Si ya lo tiene, saltamos tranquilamente

                // D. Validación: No llevar el mismo curso en dos secciones diferentes
                $cursoDuplicado = $enrollment->details()->where('course_id', $section->course_id)->exists();
                if ($cursoDuplicado) {
                    throw new Exception("Ya estás inscrito en el curso '{$section->course->name}' en otra sección.");
                }

                // 4. CREAR EL DETALLE
                $enrollment->details()->create([
                    'course_id' => $section->course_id,
                    'course_section_id' => $section->id,
                    'status' => 'enrolled',
                    'attempt_number' => 1,
                    'final_score_numeric' => null,
                    'is_legacy' => false
                ]);

                // 5. RESTAR VACANTE
                $section->decrement('vacancy_limit');
            }

            return $enrollment;
        });
    }
}
