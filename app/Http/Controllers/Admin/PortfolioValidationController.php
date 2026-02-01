<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PortfolioValidationController extends Controller
{
    public function index(Request $request)
    {
        // Traemos archivos pendientes de validación, cargando la sección, curso y profe
        $files = TeacherPortfolio::with(['section.course', 'section.teacher'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Admin/Portfolio/Validation', [
            'files' => $files,
            'currentStatus' => $request->status ?? 'all'
        ]);
    }

    public function update(Request $request, TeacherPortfolio $portfolio)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,observed',
            'feedback' => 'required_if:status,observed|nullable|string',
        ]);

        $portfolio->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback'] ?? null,
            'validated_by' => Auth::user()->person->id ?? null, // Auditoría
            'validated_at' => now(),
        ]);

        return back()->with('success', 'Documento actualizado correctamente.');
    }
}