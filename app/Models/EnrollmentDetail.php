<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentDetail extends Model
{
    protected $fillable = [
        'enrollment_id',
        'course_id',
        'course_section_id', // <--- Este es el campo que usaremos
        'final_score_numeric',
        'is_legacy',
        'status',
        'attempt_number'
    ];

    // --- RELACIONES ---

    // 1. Relación con la Sección de Curso (LA QUE FALTABA)
    public function courseSection()
    {
        // Un detalle de matrícula pertenece a una sección específica
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'enrollment_detail_id');
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}