<?php

namespace App\Http\Controllers\Admin; // <--- DEBE TENER EL \Admin

use App\Http\Controllers\Controller; // IMPORTANTE: Para que herede de la base
use App\Models\Competency;
use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompetencyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Competencies/Index', [
            'competencies' => Competency::with('domain')->orderBy('code')->get(),
            'domains' => Domain::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain_id' => 'required|exists:domains,id',
            'code' => 'required|unique:competencies,code',
            'description' => 'required|string',
        ]);

        Competency::create($validated);
        return back()->with('success', 'Competencia agregada al catálogo nacional.');
    }

    public function update(Request $request, Competency $competency)
    {
        $validated = $request->validate([
            'domain_id' => 'required|exists:domains,id',
            'code' => 'required|unique:competencies,code,' . $competency->id,
            'description' => 'required|string',
        ]);

        $competency->update($validated);
        return back()->with('success', 'Competencia actualizada correctamente.');
    }
}
