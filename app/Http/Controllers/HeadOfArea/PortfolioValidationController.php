<?php

namespace App\Http\Controllers\HeadOfArea;

use App\Http\Controllers\Controller;
use App\Models\TeacherPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PortfolioValidationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        // Traemos los archivos con toda la info del curso y el profe
        $files = TeacherPortfolio::with(['section.course', 'section.teacher'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('HeadOfArea/Portfolio/Validation', [
            'files' => $files,
            'currentStatus' => $status
        ]);
    }

    public function update(Request $request, TeacherPortfolio $portfolio)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,observed',
            'feedback' => 'required_if:status,observed|nullable|string|max:500',
        ]);

        $portfolio->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback'] ?? null,
            'validated_by' => Auth::user()->person->id, // Guardamos quién fue el jefe que aprobó
            'validated_at' => now(),
        ]);

        return back()->with('success', 'El estado del documento ha sido actualizado.');
    }
}