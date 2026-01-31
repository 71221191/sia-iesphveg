<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:domains,name',
            'description' => 'nullable|string',
        ]);

        Domain::create($validated);
        return back()->with('success', 'Dominio creado correctamente.');
    }

    public function update(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:domains,name,' . $domain->id,
            'description' => 'nullable|string',
        ]);

        $domain->update($validated);
        return back()->with('success', 'Dominio actualizado.');
    }

    public function destroy(Domain $domain)
    {
        // Validar que no tenga competencias antes de borrar
        if ($domain->competencies()->count() > 0) {
            return back()->with('error', 'No se puede eliminar un dominio que tiene competencias asociadas.');
        }

        $domain->delete();
        return back()->with('success', 'Dominio eliminado.');
    }
}
