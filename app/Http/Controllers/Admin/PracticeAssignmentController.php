<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PracticeAssignment;
use App\Models\PracticeCenter;
use App\Models\Person;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PracticeAssignmentController extends Controller
{
    public function index()
    {
        $period = AcademicPeriod::where('status', 'open')->first();

        if (!$period) {
            return redirect()->route('dashboard')->with('error', 'No hay un periodo académico abierto.');
        }

        return Inertia::render('Admin/PracticeAssignments/Index', [
            // Traemos las asignaciones actuales con toda su información
            'assignments' => PracticeAssignment::with(['student', 'teacher', 'center'])
                ->where('academic_period_id', $period->id)
                ->get(),
            
            // Datos para los selectores del formulario
            'students' => Person::whereHas('user.roles', fn($q) => $q->where('name', 'estudiante'))->get(['id', 'names', 'last_name_p', 'last_name_m']),
            'teachers' => Person::whereHas('user.roles', fn($q) => $q->where('name', 'docente'))->get(['id', 'names', 'last_name_p', 'last_name_m']),
            'centers' => PracticeCenter::where('is_active', true)->get(['id', 'name', 'level']),
            'currentPeriod' => $period
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'student_id' => 'required|exists:people,id',
            'teacher_id' => 'required|exists:people,id',
            'practice_center_id' => 'required|exists:practice_centers,id',
            'classroom_teacher_name' => 'nullable|string|max:255',
            'grade_and_section' => 'nullable|string|max:50',
        ]);

        // Evitar que el alumno sea asignado dos veces en el mismo periodo
        $exists = PracticeAssignment::where('student_id', $request->student_id)
            ->where('academic_period_id', $request->academic_period_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['student_id' => 'Este estudiante ya tiene una asignación de práctica para este periodo.']);
        }

        PracticeAssignment::create($validated);

        return back()->with('success', 'Asignación de práctica creada correctamente.');
    }

    public function destroy(PracticeAssignment $practiceAssignment)
    {
        $practiceAssignment->delete();
        return back()->with('success', 'Asignación eliminada.');
    }
}