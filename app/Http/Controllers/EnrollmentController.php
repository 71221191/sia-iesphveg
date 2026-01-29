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
        $user = Auth::user();
        $person = Person::where('user_id', $user->id)->firstOrFail();
        $period = AcademicPeriod::where('status', 'open')->first();

        if (!$period) {
            return redirect()->route('dashboard')->with('error', 'No hay un proceso de matrícula activo.');
        }

        // Obtenemos los requisitos administrativos (Ficha, Pago, Biblioteca)
        $requirements = $this->enrollmentService->checkAdministrativeRequirements($person, $period);

        // Obtenemos los cursos con su lógica de malla (Colores y Estados)
        $availableSections = $this->enrollmentService->getAvailableSectionsWithStatus($person, $period);

        return Inertia::render('Enrollment/Create', [
            'requirements' => $requirements,
            'availableSections' => $availableSections,
            'studentStudyPlanId' => $person->study_plan_id ?? 0,
            'currentPeriod' => $period->name,
            'currentPeriodId' => $period->id,
            'student' => $person->names,
            'sectionsByCycle' => $availableSections->groupBy('cycle'),
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
