<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeAssignment extends Model
{
    protected $fillable = [
        'academic_period_id', 'student_id', 'practice_center_id', 
        'teacher_id', 'classroom_teacher_name', 'grade_and_section'
    ];

    public function student() { return $this->belongsTo(Person::class, 'student_id'); }
    public function teacher() { return $this->belongsTo(Person::class, 'teacher_id'); }
    public function center() { return $this->belongsTo(PracticeCenter::class, 'practice_center_id'); }

    // --- AÑADE ESTA RELACIÓN ---
    public function evaluation()
    {
        // Una asignación tiene una evaluación de práctica
        return $this->hasOne(PracticeEvaluation::class, 'practice_assignment_id');
    }
}