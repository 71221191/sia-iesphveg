<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'academic_period_id',
        'name',
        'teacher_id',
        'vacancy_limit',
        'is_closed',
        'acta_number',
        'acta_close_date'
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'acta_close_date' => 'datetime',
    ];

    // --- RELACIONES ---

    // 1. NUEVA: Una sección tiene muchas sesiones de asistencia
    public function classSessions()
    {
        return $this->hasMany(ClassSession::class, 'course_section_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    // 2. CORREGIDA: El docente ahora apunta a Person (ID 2578) y no a User (ID 2579)
    public function teacher()
    {
        return $this->belongsTo(Person::class, 'teacher_id');
    }

    public function enrollmentDetails()
    {
        return $this->hasMany(EnrollmentDetail::class, 'course_section_id');
    }

    public function portfolios() {
        return $this->hasMany(TeacherPortfolio::class);
        }

    // Un "Helper" para saber si tiene el sílabo aprobado
    public function isSyllabusApproved() {
        return $this->portfolios()
            ->where('type', 'syllabus')
            ->where('status', 'approved')
            ->exists();
    }
}
