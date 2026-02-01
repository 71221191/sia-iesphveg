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

    public function getAvailableSectionsWithStatus(Person $person, AcademicPeriod $period)
    {
        // 1. Cursos APROBADOS en el pasado
        $approvedCourseIds = DB::table('enrollment_details')
            ->join('enrollments', 'enrollment_details.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.person_id', $person->id)
            ->where('enrollment_details.status', 'approved')
            ->pluck('enrollment_details.course_id')
            ->toArray();

        // 2. NUEVA LÓGICA: Cursos ya MATRICULADOS en este periodo actual
        $alreadyEnrolledCourseIds = DB::table('enrollment_details')
            ->join('enrollments', 'enrollment_details.enrollment_id', '=', 'enrollments.id')
            ->where('enrollments.person_id', $person->id)
            ->where('enrollments.academic_period_id', $period->id)
            ->pluck('enrollment_details.course_id')
            ->toArray();

        $sections = CourseSection::with(['course.prerequisites', 'teacher'])
            ->where('academic_period_id', $period->id)
            ->get();

        return $sections->map(function ($section) use ($approvedCourseIds, $alreadyEnrolledCourseIds) {
            $course = $section->course;
            $status = 'available';
            $lockReason = null;

            // REGLA A: ¿Ya lo aprobó antes?
            if (in_array($course->id, $approvedCourseIds)) {
                $status = 'passed';
            }
            // REGLA B (NUEVA): ¿Ya está matriculado en este ciclo?
            elseif (in_array($course->id, $alreadyEnrolledCourseIds)) {
                $status = 'enrolled'; // Estado nuevo
                $lockReason = "Ya estás matriculado en este curso.";
            }
            else {
                // REGLA C: ¿Cumple prerrequisitos?
                foreach ($course->prerequisites as $prereq) {
                    if (!in_array($prereq->prerequisite_course_id, $approvedCourseIds)) {
                        $status = 'locked';
                        $missingCourse = Course::find($prereq->prerequisite_course_id);
                        $lockReason = "Falta aprobar: " . ($missingCourse ? $missingCourse->name : 'Prerrequisito');
                        break;
                    }
                }
            }

            // REGLA D: Vacantes
            $inscritos = DB::table('enrollment_details')
                ->where('course_section_id', $section->id)
                ->count();
            $disponibles = $section->vacancy_limit - $inscritos;

            if ($status === 'available' && $disponibles <= 0) {
                $status = 'no_vacancies';
                $lockReason = "Ya no quedan vacantes";
            }

            return [
                'id' => $section->id,
                'cycle' => $course->cycle,
                'course_code' => $course->code,
                'course_name' => $course->name,
                'credits' => $course->credits,
                'section_name' => $section->name,
                'teacher_name' => $section->teacher ? $section->teacher->names : 'Por asignar',
                'status' => $status, // 'available', 'locked', 'passed', 'no_vacancies', 'enrolled'
                'lock_reason' => $lockReason,
                'vacancy_limit' => $section->vacancy_limit,
                'remaining_vacancies' => $disponibles,
            ];
        });
    }

    public function checkAdministrativeRequirements(Person $person, AcademicPeriod $period)
    {
        // 1. Check Ficha
        $ficha = DB::table('socioeconomic_files')
            ->where('person_id', $person->id)
            ->where('academic_period_id', $period->id)
            ->first();
        $fichaOk = ($ficha && $ficha->is_validated);

        // 2. Check Biblioteca (Si no hay registro o debt es 0, está OK)
        $lastEnrollment = DB::table('enrollments')
            ->where('person_id', $person->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $bibliotecaOk = !($lastEnrollment && $lastEnrollment->library_debt);

        // 3. Check Pago / Beca
        $tieneBeca = !is_null($person->scholarship_type_id) && $person->scholarship_type_id > 1;
        $pagoOk = $tieneBeca || DB::table('payments')
            ->where('person_id', $person->id)
            ->where('concept', 'Matrícula')
            ->where('status', 'approved')
            ->exists();

        return [
            'can_enroll' => ($fichaOk && $bibliotecaOk && $pagoOk), // Solo si los 3 son true
            'details' => [
                'ficha' => $fichaOk,
                'biblioteca' => $bibliotecaOk,
                'pago' => $pagoOk,
            ]
        ];
    }
}
