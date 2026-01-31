<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_detail_id',
        'competency_id',
        'grade_scale_id',
        'comment',
        'registered_by',
        'registered_at'
    ];

    // Relación con el alumno en el curso
    public function enrollmentDetail()
    {
        return $this->belongsTo(EnrollmentDetail::class);
    }

    // Relación con la competencia
    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    // Relación con la nota (AD, A, B...)
    public function gradeScale()
    {
        return $this->belongsTo(GradeScale::class);
    }
}
