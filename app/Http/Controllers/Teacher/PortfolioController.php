<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\TeacherPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index(CourseSection $section)
    {
        $section->load('course');
        // Traemos los archivos ya subidos para esta sección
        $files = TeacherPortfolio::where('course_section_id', $section->id)->get();

        return Inertia::render('Teacher/Portfolio/Index', [
            'section' => $section,
            'files' => $files
        ]);
    }

    public function store(Request $request, CourseSection $section)
    {
        $request->validate([
            'type' => 'required|in:syllabus,session,instrument',
            'name' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf|max:2048', // Solo PDF, max 2MB
        ], [
            'file.mimes' => 'Solo se permiten archivos en formato PDF.',
            'file.max' => 'El archivo no debe pesar más de 2MB.'
        ]);

        // Guardar archivo en storage/app/public/portfolios
        $path = $request->file('file')->store('portfolios', 'public');

        TeacherPortfolio::create([
            'course_section_id' => $section->id,
            'type' => $request->type,
            'name' => $request->name,
            'file_path' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Documento subido correctamente. En espera de validación.');
    }

    public function destroy(TeacherPortfolio $portfolio)
    {
        // Solo permitir borrar si no ha sido aprobado
        if ($portfolio->status === 'approved') {
            return back()->with('error', 'No se puede eliminar un archivo ya aprobado.');
        }

        Storage::disk('public')->delete($portfolio->file_path);
        $portfolio->delete();

        return back()->with('success', 'Documento eliminado.');
    }
}