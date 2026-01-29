<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'person_id',
        'academic_period_id', // Periodo académico de la matrícula
        'course_section_id',
        'academic_period_id',
        'study_plan_id',
        'cycle',
        'enrollment_type_id',
        'shift_id',
        'status',
        'section_label'
    ];

    // Relación con Person
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    // Relación con AcademicPeriod
    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    // Relación con CourseSection
    public function courseSection()
    {
        return $this->belongsTo(CourseSection::class);
    }

    // Relación con StudyPlan
    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function details()
    {
        // Una matrícula tiene muchos cursos detallados (notas)
        return $this->hasMany(EnrollmentDetail::class);
    }

}
