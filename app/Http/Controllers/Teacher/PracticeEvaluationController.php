<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\PracticeAssignment;
use App\Models\PracticeEvaluation;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PracticeEvaluationController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->person;

        // Traemos los alumnos que este profesor tiene asignados para supervisar
        $assignments = PracticeAssignment::with(['student', 'center', 'evaluation'])
            ->where('teacher_id', $teacher->id)
            ->get();

        return Inertia::render('Teacher/Practice/Index', [
            'assignments' => $assignments
        ]);
    }

    public function store(Request $request, PracticeAssignment $assignment)
    {
        $validated = $request->validate([
            'institute_score' => 'required|numeric|min:0|max:20',
            'school_score' => 'required|numeric|min:0|max:20',
            'observations' => 'nullable|string'
        ]);

        // Calculamos el promedio simple (o el que pida el instituto)
        $finalScore = ($validated['institute_score'] + $validated['school_score']) / 2;

        PracticeEvaluation::updateOrCreate(
            ['practice_assignment_id' => $assignment->id],
            [
                'institute_score' => $validated['institute_score'],
                'school_score' => $validated['school_score'],
                'final_score' => $finalScore,
                'observations' => $validated['observations']
            ]
        );

        return back()->with('success', 'Evaluación de práctica guardada.');
    }
}