<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\ClassSession;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(CourseSection $section)
    {
        // Traemos las sesiones de esta sección ordenadas por fecha
        $sessions = $section->classSessions()->orderBy('date', 'desc')->get();

        return Inertia::render('Teacher/Attendance/Index', [
            'section' => $section->load('course'),
            'sessions' => $sessions
        ]);
    }

    public function show(ClassSession $session)
    {
        $session->load('section.course');

        // Usamos el servicio para traer la lista de alumnos
        $students = $this->attendanceService->getStudentsForAttendance($session);

        return Inertia::render('Teacher/Attendance/Sheet', [
            'session' => $session,
            'students' => $students
        ]);
    }
    public function storeSession(Request $request, CourseSection $section)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'topic' => 'required|string|max:255',
        ]);

        $session = $section->classSessions()->create([
            'date' => $validated['date'],
            'topic' => $validated['topic'],
            'is_executed' => false // Se marca como true al terminar de pasar lista
        ]);

        // Redirigimos directamente a la hoja de marcar asistencia
        return redirect()->route('teacher.attendance.show', $session->id)
            ->with('success', 'Sesión creada. Proceda a marcar asistencia.');
    }

    public function storeRecords(Request $request, ClassSession $session)
    {
        $validated = $request->validate([
            'records' => 'required|array',
            'records.*.person_id' => 'required|exists:people,id',
            'records.*.status' => 'required|in:present,absent,late,justified',
        ]);

        foreach ($validated['records'] as $recordData) {
            \App\Models\AttendanceRecord::updateOrCreate(
                [
                    'class_session_id' => $session->id,
                    'person_id' => $recordData['person_id'],
                ],
                [
                    'status' => $recordData['status'],
                    'sync_status' => 'synced' // Como estamos online, marcamos como sincronizado
                ]
            );
        }

        // Marcamos la sesión como ejecutada (firmada)
        $session->update(['is_executed' => true]);

        return redirect()->route('teacher.attendance.index', $session->course_section_id)
            ->with('success', 'Asistencia registrada correctamente.');
    }
}
