<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudyPlan; // Para obtener los planes de estudio para el select
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Muestra la lista de cursos.
     */
    public function index()
    {
        Log::info('[CourseController@index] Cargando lista de cursos.');
        // Cargar también la relación con StudyPlan para mostrar el nombre del plan y la carrera
        $courses = Course::with('studyPlan.studyProgram')
                         ->orderBy('study_plan_id')
                         ->orderBy('cycle')
                         ->orderBy('name')
                         ->paginate(10);

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        Log::info('[CourseController@create] Mostrando formulario de creación de curso.');
        $studyPlans = StudyPlan::with('studyProgram')->orderBy('study_program_id')->orderBy('name')->get(['id', 'study_program_id', 'name']);

        return Inertia::render('Admin/Courses/Create', [
            'studyPlans' => $studyPlans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name . ' (' . ($plan->studyProgram->short_name ?? 'N/A') . ')', // Para un select legible
                ];
            }),
            'cycles' => ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'], // Ciclos fijos
            'courseTypes' => ['general', 'specific', 'elective'], // Tipos de curso
        ]);
    }

    /**
     * Guarda un nuevo curso en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('[CourseController@store] Intentando guardar nuevo curso.');
        $validated = $request->validate([
            'study_plan_id' => 'required|exists:study_plans,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'cycle' => ['required', Rule::in(['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'])],
            'credits' => 'required|numeric|min:0.5|max:20.00',
            'hours_theory' => 'nullable|integer|min:0',
            'hours_practice' => 'nullable|integer|min:0',
            'type' => ['required', Rule::in(['general', 'specific', 'elective'])],
            'is_legacy' => 'boolean',
        ]);

        Course::create($validated);
        Log::info('[CourseController@store] Curso creado con éxito: ' . $validated['name']);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un curso existente.
     */
    public function edit(Course $course)
    {
        Log::info('[CourseController@edit] Editando curso ID: ' . $course->id);
        $studyPlans = StudyPlan::with('studyProgram')->orderBy('study_program_id')->orderBy('name')->get(['id', 'study_program_id', 'name']);

        return Inertia::render('Admin/Courses/Edit', [
            'course' => $course,
            'studyPlans' => $studyPlans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name . ' (' . ($plan->studyProgram->short_name ?? 'N/A') . ')',
                ];
            }),
            'cycles' => ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'],
            'courseTypes' => ['general', 'specific', 'elective'],
        ]);
    }

    /**
     * Actualiza un curso existente en la base de datos.
     */
    public function update(Request $request, Course $course)
    {
        Log::info('[CourseController@update] Intentando actualizar curso ID: ' . $course->id);
        $validated = $request->validate([
            'study_plan_id' => 'required|exists:study_plans,id',
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses')->ignore($course->id),
            ],
            'cycle' => ['required', Rule::in(['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'])],
            'credits' => 'required|numeric|min:0.5|max:20.00',
            'hours_theory' => 'nullable|integer|min:0',
            'hours_practice' => 'nullable|integer|min:0',
            'type' => ['required', Rule::in(['general', 'specific', 'elective'])],
            'is_legacy' => 'boolean',
        ]);

        $course->update($validated);
        Log::info('[CourseController@update] Curso ID: ' . $course->id . ' actualizado con éxito.');

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Curso actualizado exitosamente.');
    }

    /**
     * Elimina un curso.
     */
    public function destroy(Course $course)
    {
        Log::info('[CourseController@destroy] Intentando eliminar curso ID: ' . $course->id);
        // NOTA: Implementar RF-060. Un curso no debería eliminarse si tiene secciones o matrículas asociadas.
        // Por ahora, si no hay relaciones ON DELETE CASCADE, lanzará un error.
        $course->delete();
        Log::info('[CourseController@destroy] Curso ID: ' . $course->id . ' eliminado.');

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Curso eliminado exitosamente.');
    }
}
