<?php

namespace App\Services;

use App\Models\ClassSession;
use App\Models\AttendanceRecord;
use App\Models\CourseSection;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Obtiene los alumnos de una sección listos para marcar asistencia.
     */
    public function getStudentsForAttendance(ClassSession $session)
    {
        // Buscamos los alumnos matriculados en esta sección
        return DB::table('enrollment_details')
            ->join('enrollments', 'enrollment_details.enrollment_id', '=', 'enrollments.id')
            ->join('people', 'enrollments.person_id', '=', 'people.id')
            ->where('enrollment_details.course_section_id', $session->course_section_id)
            ->select('people.id', 'people.names', 'people.last_name_p', 'people.last_name_m')
            ->orderBy('people.last_name_p')
            ->get()
            ->map(function($student) use ($session) {
                // Buscamos si ya tiene una asistencia grabada para esta sesión
                $record = AttendanceRecord::where('class_session_id', $session->id)
                    ->where('person_id', $student->id)
                    ->first();

                return [
                    'person_id' => $student->id,
                    'full_name' => "{$student->last_name_p} {$student->last_name_m}, {$student->names}",
                    'status' => $record ? $record->status : 'present', // Por defecto todos presentes
                ];
            });
    }

    public function getAttendanceWarning(CourseSection $section)
    {
        // Usamos el total programado en lugar de las sesiones ejecutadas
        $totalPlanned = $section->total_planned_sessions;

        if ($totalPlanned === 0) return [];

        return DB::table('attendance_records')
            ->join('class_sessions', 'attendance_records.class_session_id', '=', 'class_sessions.id')
            ->where('class_sessions.course_section_id', $section->id)
            ->where('class_sessions.is_executed', true)
            ->select(
                'person_id',
                DB::raw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as total_absences")
            )
            ->groupBy('person_id')
            ->get()
            ->mapWithKeys(function ($item) use ($totalPlanned) {
                // CÁLCULO LEGAL: (Faltas / Total Programado) * 100
                $percentage = ($item->total_absences / $totalPlanned) * 100;
                
                return [
                    $item->person_id => [
                        'absences' => $item->total_absences,
                        'percentage' => round($percentage, 2),
                        'is_danger' => $percentage >= 30,
                        'total_planned' => $totalPlanned
                    ]
                ];
            });
    }
}
