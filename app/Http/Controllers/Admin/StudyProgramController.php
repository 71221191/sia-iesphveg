<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class StudyProgramController extends Controller
{
    /**
     * Muestra la lista de programas de estudio (carreras).
     */
    public function index()
    {
        Log::info('[StudyProgramController@index] Cargando lista de programas de estudio.');
        $studyPrograms = StudyProgram::orderBy('name')->paginate(10);

        return Inertia::render('Admin/StudyPrograms/Index', [
            'studyPrograms' => $studyPrograms,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo programa de estudio.
     */
    public function create()
    {
        Log::info('[StudyProgramController@create] Mostrando formulario de creación de programa de estudio.');
        return Inertia::render('Admin/StudyPrograms/Create');
    }

    /**
     * Guarda un nuevo programa de estudio en la base de datos.
     */
    public function store(Request $request)
    {
        Log::info('[StudyProgramController@store] Intentando guardar nuevo programa de estudio.');
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:study_programs,name',
            'code' => 'nullable|string|max:50|unique:study_programs,code',
            'short_name' => 'nullable|string|max:100',
        ]);

        StudyProgram::create($validated);
        Log::info('[StudyProgramController@store] Programa de estudio creado con éxito: ' . $validated['name']);

        return redirect()->route('admin.study_programs.index')
                         ->with('success', 'Programa de estudio creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un programa de estudio existente.
     */
    public function edit(StudyProgram $studyProgram)
    {
        Log::info('[StudyProgramController@edit] Editando programa de estudio ID: ' . $studyProgram->id);
        return Inertia::render('Admin/StudyPrograms/Edit', [
            'studyProgram' => $studyProgram,
        ]);
    }

    /**
     * Actualiza un programa de estudio existente en la base de datos.
     */
    public function update(Request $request, StudyProgram $studyProgram)
    {
        Log::info('[StudyProgramController@update] Intentando actualizar programa de estudio ID: ' . $studyProgram->id);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('study_programs')->ignore($studyProgram->id),
            ],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('study_programs')->ignore($studyProgram->id),
            ],
            'short_name' => 'nullable|string|max:100',
        ]);

        $studyProgram->update($validated);
        Log::info('[StudyProgramController@update] Programa de estudio ID: ' . $studyProgram->id . ' actualizado con éxito.');

        return redirect()->route('admin.study_programs.index')
                         ->with('success', 'Programa de estudio actualizado exitosamente.');
    }

    /**
     * Elimina un programa de estudio.
     */
    public function destroy(StudyProgram $studyProgram)
    {
        Log::info('[StudyProgramController@destroy] Intentando eliminar programa de estudio ID: ' . $studyProgram->id);
        // NOTA: Considera añadir una validación aquí para evitar eliminar programas
        // que tienen planes de estudio o alumnos asociados (integridad referencial).
        // Por ahora, si no hay relaciones ON DELETE CASCADE en la BD, lanzará un error.
        $studyProgram->delete();
        Log::info('[StudyProgramController@destroy] Programa de estudio ID: ' . $studyProgram->id . ' eliminado.');

        return redirect()->route('admin.study_programs.index')
                         ->with('success', 'Programa de estudio eliminado exitosamente.');
    }
}
