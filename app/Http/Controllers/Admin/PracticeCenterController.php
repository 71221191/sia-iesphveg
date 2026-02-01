<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PracticeCenter;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PracticeCenterController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/PracticeCenter/Index', [
            'centers' => PracticeCenter::with('ubigeo')->get(),
            // Enviamos los ubigeos para el buscador del formulario (puedes filtrar por Cajamarca)
            'ubigeos' => Ubigeo::where('department', 'CAJAMARCA')->get(['id', 'district', 'province'])
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'modular_code' => 'required|string|unique:practice_centers,modular_code',
            'level' => 'required|in:inicial,primaria,secundaria',
            'director_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'ubigeo_id' => 'required|exists:ubigeos,id',
        ]);

        PracticeCenter::create($validated);
        return back()->with('success', 'Centro de práctica registrado correctamente.');
    }

    public function update(Request $request, PracticeCenter $practiceCenter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'modular_code' => 'required|string|unique:practice_centers,modular_code,' . $practiceCenter->id,
            'level' => 'required|in:inicial,primaria,secundaria',
            'director_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'ubigeo_id' => 'required|exists:ubigeos,id',
        ]);

        $practiceCenter->update($validated);
        return back()->with('success', 'Información de la I.E. actualizada.');
    }
}