<?php

namespace App\Http\Controllers;

use App\Models\StudyPlan; // Añadir este modelo para la matrícula // Para depuración // Necesario para prerrequisitos // Para obtener nombres de cursos en errores
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicPeriod;
use App\Models\Person;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\CoursePrerequisite;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationFactory;
use Illuminate\Validation\ValidationException;
use App\Services\EnrollmentService;
use App\Http\Requests\StoreEnrollmentRequest;

class EnrollmentController extends Controller
{
    protected $enrollmentService;

     // Inyectamos el servicio
    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Muestra la interfaz para que el alumno seleccione cursos para matricularse.
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Obtener datos del alumno
        $person = Person::where('user_id', $user->id)->firstOrFail();

        // 2. Obtener periodo activo
        $period = AcademicPeriod::where('status', 'open')->first();

        if (!$period) {
            return redirect()->route('dashboard')
                ->with('error', 'No hay un proceso de matrícula activo en este momento.');
        }

        // 3. Obtener las Secciones Disponibles para SU Plan de Estudios
        // (Aquí filtramos para que no vea cursos de otras carreras)
        $availableSections = CourseSection::with('course')
            ->where('academic_period_id', $period->id)
            ->whereHas('course', function ($query) use ($person) {
                // Asumimos que la persona tiene un plan asignado.
                // Si importamos bien, debería tenerlo en su última matrícula o inferirlo.
                // Por ahora, traemos TODO del periodo.
                // En una V2 filtraremos por $person->study_plan_id
            })
            ->get()
            ->groupBy('course.cycle'); // Agrupamos por ciclo (I, II, III...)

        return Inertia::render('Enrollment/Create', [
            'availableSections' => $availableSections->flatten()->values(), //
            'currentPeriod' => $period->name,
            'currentPeriodId' => $period->id,
            'studentStudyPlanId' => $person->study_plan_id ?? 0,
        ]);
    }
    /**
     * Procesa la matrícula de los cursos seleccionados por el alumno.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        try {
            // El trabajo sucio lo hace el servicio
            $this->enrollmentService->registerEnrollment(
                Auth::user(),
                $request->validated()['sections'] // Usamos 'sections' porque así lo definimos en el Request
            );

            return redirect()->route('dashboard')
                ->with('success', '¡Matrícula procesada exitosamente!');

        } catch (\Exception $e) {
            // Si falla algo (vacantes, prerrequisitos), volvemos con el error
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
