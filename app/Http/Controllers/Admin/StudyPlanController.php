<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyPlan;
use App\Models\StudyProgram; // Para obtener las carreras al crear/editar
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class StudyPlanController extends Controller
{
    /**
     * Muestra la lista de planes de estudio.
     */
    public function index()
    {
        Log::info('[StudyPlanController@index] Cargando lista de planes de estudio.');
        // Cargar también la relación con StudyProgram para mostrar el nombre de la carrera
        $studyPlans = StudyPlan::with('studyProgram')
                               ->orderBy('study_program_id')
                               ->orderBy('name', 'desc')
                               ->paginate(10);

        return Inertia::render('Admin/StudyPlans/Index', [
            'studyPlans' => $studyPlans,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo plan de estudio.
     */
    public function create()
    {
        Log::info('[StudyPlanController@create] Mostrando formulario de creación de plan de estudio.');
        $studyPrograms = StudyProgram::orderBy('name')->get(['id', 'name', 'short_name']); // Necesario para el select

        return Inertia::render('Admin/StudyPlans/Create', [
            'studyPrograms' => $studyPrograms,
        ]);
    }

    /**
     * Guarda un nuevo plan de estudio en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('[StudyPlanController@store] Intentando guardar nuevo plan de estudio.');
        $validated = $request->validate([
            'study_program_id' => 'required|exists:study_programs,id',
            'name' => [
                'required',
                'string',
                'max:255',
                // Validación única por programa de estudio y nombre
                Rule::unique('study_plans')->where(function ($query) use ($request) {
                    return $query->where('study_program_id', $request->study_program_id);
                }),
            ],
            'resolution_code' => 'nullable|string|max:255',
            'evaluation_type' => ['required', Rule::in(['vigesimal', 'competency'])],
            'is_active' => 'boolean',
            'valid_from_year' => 'required|integer|min:1900|max:' . (date('Y') + 5), // Año actual + 5
            'valid_to_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5) . '|after_or_equal:valid_from_year',
        ]);

        StudyPlan::create($validated);
        Log::info('[StudyPlanController@store] Plan de estudio creado con éxito: ' . $validated['name']);

        return redirect()->route('admin.study_plans.index')
                         ->with('success', 'Plan de estudio creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un plan de estudio existente.
     */
    public function edit(StudyPlan $studyPlan)
    {
        Log::info('[StudyPlanController@edit] Editando plan de estudio ID: ' . $studyPlan->id);
        $studyPrograms = StudyProgram::orderBy('name')->get(['id', 'name', 'short_name']);

        return Inertia::render('Admin/StudyPlans/Edit', [
            'studyPlan' => $studyPlan,
            'studyPrograms' => $studyPrograms,
        ]);
    }

    /**
     * Actualiza un plan de estudio existente en la base de datos.
     */
    public function update(Request $request, StudyPlan $studyPlan)
    {
        Log::info('[StudyPlanController@update] Intentando actualizar plan de estudio ID: ' . $studyPlan->id);
        $validated = $request->validate([
            'study_program_id' => 'required|exists:study_programs,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('study_plans')->where(function ($query) use ($request) {
                    return $query->where('study_program_id', $request->study_program_id);
                })->ignore($studyPlan->id), // Ignorar el propio ID al actualizar
            ],
            'resolution_code' => 'nullable|string|max:255',
            'evaluation_type' => ['required', Rule::in(['vigesimal', 'competency'])],
            'is_active' => 'boolean',
            'valid_from_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'valid_to_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5) . '|after_or_equal:valid_from_year',
        ]);

        $studyPlan->update($validated);
        Log::info('[StudyPlanController@update] Plan de estudio ID: ' . $studyPlan->id . ' actualizado con éxito.');

        return redirect()->route('admin.study_plans.index')
                         ->with('success', 'Plan de estudio actualizado exitosamente.');
    }

    /**
     * Elimina un plan de estudio.
     */
    public function destroy(StudyPlan $studyPlan)
    {
        Log::info('[StudyPlanController@destroy] Intentando eliminar plan de estudio ID: ' . $studyPlan->id);
        // NOTA: Muy importante: Implementar RF-060 o similar.
        // Un plan de estudio no debería eliminarse si tiene cursos o alumnos asociados.
        // Por ahora, si no hay relaciones ON DELETE CASCADE, lanzará un error.
        $studyPlan->delete();
        Log::info('[StudyPlanController@destroy] Plan de estudio ID: ' . $studyPlan->id . ' eliminado.');

        return redirect()->route('admin.study_plans.index')
                         ->with('success', 'Plan de estudio eliminado exitosamente.');
    }
}
