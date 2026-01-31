<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Services\GradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;

class GradeController extends Controller
{
    protected $gradeService;

    public function __construct(GradeService $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    public function store(Request $request, CourseSection $section)
    {
        $teacher = Person::where('user_id', Auth::id())->firstOrFail();

        try {
            $this->gradeService->saveGrades($section, $request->students, $teacher->id);
            return back()->with('success', 'Calificaciones guardadas correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
