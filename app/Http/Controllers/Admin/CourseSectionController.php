<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Course; // Para obtener los cursos
use App\Models\AcademicPeriod; // Para obtener los períodos
use App\Models\User; // Para obtener los docentes
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\StudyProgram;
use App\Models\StudyPlan;

class CourseSectionController extends Controller
{
    /**
     * Muestra la lista de secciones de cursos.
     */
    public function index()
    {
        Log::info('[CourseSectionController@index] Cargando lista de secciones de cursos.');
        $courseSections = CourseSection::with('course.studyPlan.studyProgram', 'academicPeriod', 'teacher.person')
                                       ->orderBy('academic_period_id', 'desc')
                                       ->orderBy('course_id')
                                       ->orderBy('name')
                                       ->paginate(10);

        return Inertia::render('Admin/CourseSections/Index', [
            'courseSections' => $courseSections,
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva sección de curso.
     */
    public function create()
    {
        Log::info('[CourseSectionController@create] Mostrando formulario de creación de sección de curso.');

        $studyPrograms = StudyProgram::orderBy('name')->get(['id', 'name', 'short_name']);
        $studyPlans = StudyPlan::with('studyProgram')->orderBy('study_program_id')->orderBy('name')->get(['id', 'study_program_id', 'name']);

        // ¡IMPORTANTE! Asegurarnos que 'cycle' se esté seleccionando de la base de datos
        $courses = Course::with('studyPlan.studyProgram')
                         ->orderBy('study_plan_id')->orderBy('name')
                         ->get(['id', 'study_plan_id', 'name', 'code', 'cycle']); // <-- Asegúrate de que 'cycle' esté aquí

        Log::info('[CourseSectionController@create] Primeros 5 cursos antes de mapear: ' . json_encode($courses->take(5))); // <-- NUEVO LOG

        $academicPeriods = AcademicPeriod::orderBy('start_date', 'desc')->get(['id', 'name', 'status']);

        // 1. Buscamos los usuarios con rol docente y cargamos su relación 'person'
        $teachers = User::role('docente')->with('person')->get();

        // 2. Mapeamos la colección
        $teachers = $teachers->map(function ($userDocente) {
            // IMPORTANTE: Si el usuario no tiene una persona vinculada, lo saltamos para evitar errores
            if (!$userDocente->person) return null;

            return [
                'id' => $userDocente->person->id, // <--- LA CLAVE: Mandamos el ID de la tabla PEOPLE (2578)
                'name' => $userDocente->person->full_name ?? $userDocente->username,
            ];
        })->filter()->values(); // Limpiamos los nulos si los hubiera

        return Inertia::render('Admin/CourseSections/Create', [
            'studyPrograms' => $studyPrograms,
            'studyPlans' => $studyPlans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'study_program_id' => $plan->study_program_id,
                    'name' => $plan->name . ' (' . ($plan->studyProgram->short_name ?? 'N/A') . ')',
                ];
            }),
            'courses' => $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'study_plan_id' => $course->study_plan_id,
                    'name' => $course->name . ' (' . $course->code . ')',
                    'cycle' => $course->cycle, // <-- Asegúrate de que 'cycle' se pase aquí
                ];
            }),
            'academicPeriods' => $academicPeriods,
            'teachers' => $teachers,
        ]);
    }

    /**
     * Guarda una nueva sección de curso en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('[CourseSectionController@store] Intentando guardar nueva sección de curso.');
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('course_sections')->where(function ($query) use ($request) {
                    return $query->where('course_id', $request->course_id)
                                 ->where('academic_period_id', $request->academic_period_id);
                }),
            ],
            'teacher_id' => 'nullable|exists:users,id', // Se valida que exista como usuario
            'vacancy_limit' => 'required|integer|min:0',
            // is_closed, acta_number, acta_close_date no se establecen al crear
        ]);

        CourseSection::create($validated);
        Log::info('[CourseSectionController@store] Sección de curso creada con éxito: ' . $validated['name']);

        return redirect()->route('admin.course_sections.index')
                         ->with('success', 'Sección de curso creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una sección de curso existente.
     */
    public function edit(CourseSection $courseSection)
    {
        Log::info('[CourseSectionController@edit] Editando sección de curso ID: ' . $courseSection->id);

        $courseSection->load('course.studyPlan.studyProgram');

        $studyPrograms = StudyProgram::orderBy('name')->get(['id', 'name', 'short_name']);
        $studyPlans = StudyPlan::with('studyProgram')->orderBy('study_program_id')->orderBy('name')->get(['id', 'study_program_id', 'name']);
        // ¡IMPORTANTE! Asegurarnos que 'cycle' se esté seleccionando de la base de datos
        $courses = Course::with('studyPlan.studyProgram')->orderBy('study_plan_id')->orderBy('name')->get(['id', 'study_plan_id', 'name', 'code', 'cycle']); // <-- Asegúrate de que 'cycle' esté aquí

        Log::info('[CourseSectionController@edit] Primeros 5 cursos antes de mapear: ' . json_encode($courses->take(5))); // <-- NUEVO LOG

        $academicPeriods = AcademicPeriod::orderBy('start_date', 'desc')->get(['id', 'name', 'status']);

        // 1. Buscamos los usuarios con rol docente y cargamos su relación 'person'
        $teachers = User::role('docente')->with('person')->get();

        // 2. Mapeamos la colección
        $teachers = $teachers->map(function ($userDocente) {
            // IMPORTANTE: Si el usuario no tiene una persona vinculada, lo saltamos para evitar errores
            if (!$userDocente->person) return null;

            return [
                'id' => $userDocente->person->id, // <--- LA CLAVE: Mandamos el ID de la tabla PEOPLE (2578)
                'name' => $userDocente->person->full_name ?? $userDocente->username,
            ];
        })->filter()->values(); // Limpiamos los nulos si los hubiera

        return Inertia::render('Admin/CourseSections/Edit', [
            'courseSection' => $courseSection,
            'studyPrograms' => $studyPrograms,
            'studyPlans' => $studyPlans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'study_program_id' => $plan->study_program_id,
                    'name' => $plan->name . ' (' . ($plan->studyProgram->short_name ?? 'N/A') . ')',
                ];
            }),
            'courses' => $courses->map(function ($course) { // <-- También pasar 'cycle' mapeado
                return [
                    'id' => $course->id,
                    'study_plan_id' => $course->study_plan_id,
                    'name' => $course->name . ' (' . $course->code . ')',
                    'cycle' => $course->cycle, // <-- NUEVO: Incluir ciclo
                ];
            }),
            'academicPeriods' => $academicPeriods,
            'teachers' => $teachers,
        ]);
    }

    /**
     * Actualiza una sección de curso existente en la base de datos.
     */
    public function update(Request $request, CourseSection $courseSection)
    {
        Log::info('[CourseSectionController@update] Intentando actualizar sección de curso ID: ' . $courseSection->id);
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_period_id' => 'required|exists:academic_periods,id',
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('course_sections')->where(function ($query) use ($request, $courseSection) {
                    return $query->where('course_id', $request->course_id)
                                 ->where('academic_period_id', $request->academic_period_id)
                                 ->where('id', '!=', $courseSection->id); // Ignorar el propio ID al actualizar
                }),
            ],
            'teacher_id' => 'nullable|exists:users,id',
            'vacancy_limit' => 'required|integer|min:0',
            'is_closed' => 'boolean',
            'acta_number' => 'nullable|string|max:100',
            'acta_close_date' => 'nullable|date',
        ]);

        $courseSection->update($validated);
        Log::info('[CourseSectionController@update] Sección de curso ID: ' . $courseSection->id . ' actualizada con éxito.');

        return redirect()->route('admin.course_sections.index')
                         ->with('success', 'Sección de curso actualizada exitosamente.');
    }

    /**
     * Elimina una sección de curso.
     */
    public function destroy(CourseSection $courseSection)
    {
        Log::info('[CourseSectionController@destroy] Intentando eliminar sección de curso ID: ' . $courseSection->id);
        // NOTA: Implementar RF-060. Una sección no debería eliminarse si tiene matrículas asociadas.
        $courseSection->delete();
        Log::info('[CourseSectionController@destroy] Sección de curso ID: ' . $courseSection->id . ' eliminada.');

        return redirect()->route('admin.course_sections.index')
                         ->with('success', 'Sección de curso eliminada exitosamente.');
    }
}
