<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\AcademicPeriod;
use App\Services\AttendanceService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProgressController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $user = Auth::user();
        $person = $user->person;
        $period = AcademicPeriod::where('status', 'open')->first();

        if (!$period) {
            return redirect()->route('dashboard')->with('error', 'No hay un periodo activo.');
        }

        // 1. Obtener los cursos donde el alumno está matriculado actualmente
        $enrolledCourses = $person->enrollments()
            ->where('academic_period_id', $period->id)
            ->with(['details.course', 'details.courseSection', 'details.grades.gradeScale'])
            ->first();

        $progress = [];

        if ($enrolledCourses) {
            foreach ($enrolledCourses->details as $detail) {
                // 2. Obtener estadísticas de asistencia para este curso específico
                $attendanceStats = $this->attendanceService->getAttendanceWarning($detail->courseSection);
                $myAttendance = $attendanceStats[$person->id] ?? [
                    'absences' => 0,
                    'percentage' => 0,
                    'is_danger' => false,
                    'total_planned' => $detail->courseSection->total_planned_sessions
                ];

                // 3. Organizar la data para Vue
                $progress[] = [
                    'course_name' => $detail->course->name,
                    'course_code' => $detail->course->code,
                    'section' => $detail->courseSection->name,
                    'current_grade' => $detail->final_score_numeric, // La nota que calcula el GradeService
                    'status' => $detail->status,
                    'attendance' => $myAttendance
                ];
            }
        }

        return Inertia::render('Student/Progress', [
            'progress' => $progress,
            'studentName' => $person->names,
            'periodName' => $period->name
        ]);
    }
}