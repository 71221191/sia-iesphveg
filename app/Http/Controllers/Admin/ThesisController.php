<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThesisProject;
use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThesisController extends Controller
{
    public function index(Request $request)
    {
        $projects = ThesisProject::with(['authors', 'advisor'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('authors', function($q) use ($search) {
                        $q->where('last_name_p', 'like', "%{$search}%")
                            ->orWhere('names', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString(); // IMPORTANTE: Mantiene el texto de búsqueda al cambiar de página

        return Inertia::render('Admin/Thesis/Index', [
            'projects' => $projects,
            'filters' => $request->only(['search'])
        ]);
    }

    public function show(ThesisProject $project)
    {
        // Detalle del proyecto para asignar asesor y jurados
        $project->load(['authors', 'advisor', 'jurors.teacher']);

        // Traemos a los docentes disponibles para ser asesores o jurados
        $teachers = Person::whereHas('user.roles', fn($q) => $q->where('name', 'docente'))
            ->get(['id', 'names', 'last_name_p', 'last_name_m']);

        return Inertia::render('Admin/Thesis/Show', [
            'project' => $project,
            'teachers' => $teachers
        ]);
    }

    public function assignAdvisor(Request $request, ThesisProject $project)
    {
        $validated = $request->validate([
            'advisor_id' => 'required|exists:people,id',
        ]);

        $project->update([
            'advisor_id' => $validated['advisor_id'],
            'status' => 'approved' // Al asignar asesor, el proyecto queda aprobado para iniciar
        ]);

        return back()->with('success', 'Asesor asignado correctamente.');
    }
    public function assignJurors(Request $request, ThesisProject $project)
    {
        $validated = $request->validate([
            'jurors' => 'required|array|size:3',
            'jurors.*.teacher_id' => 'required|exists:people,id',
            'jurors.*.role' => 'required|in:presidente,secretario,vocal',
        ]);

        $jurorIds = collect($validated['jurors'])->pluck('teacher_id')->toArray();

        // 1. REGLA: El asesor no puede ser jurado (Ya la tenías)
        if (in_array($project->advisor_id, $jurorIds)) {
            return back()->withErrors(['jurors' => 'Conflicto de interés: El asesor no puede ser jurado.']);
        }

        // 2. REGLA NUEVA: Los 3 jurados deben ser personas distintas
        // array_unique elimina duplicados; si el conteo baja de 3, es que hubo repetidos
        if (count(array_unique($jurorIds)) < 3) {
            return back()->withErrors(['jurors' => 'Error: Debe seleccionar tres docentes distintos para el jurado.']);
        }

        $project->jurors()->delete();
        foreach ($validated['jurors'] as $jurorData) {
            $project->jurors()->create($jurorData);
        }

        return back()->with('success', 'Jurados nombrados exitosamente.');
    }

    public function recordDefense(Request $request, ThesisProject $project)
    {
        $validated = $request->validate([
            'defense_date' => 'required|date',
            'defense_time' => 'required',
            'modality' => 'required|in:presencial,virtual',
            'score' => 'required|numeric|min:0|max:20',
            'result' => 'required|in:aprobado,desaprobado',
        ]);

        // Usamos updateOrCreate por si necesitan corregir la fecha antes de cerrar
        $project->defenseAct()->updateOrCreate(
            ['thesis_project_id' => $project->id],
            $validated
        );

        // Si aprobó, actualizamos el estado del proyecto
        if ($validated['result'] === 'aprobado') {
            $project->update(['status' => 'defended']);
        }

        return back()->with('success', 'Resultado de sustentación registrado.');
}
}
