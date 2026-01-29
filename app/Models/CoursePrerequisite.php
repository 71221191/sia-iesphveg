<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePrerequisite extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'prerequisite_course_id',
    ];

    // El curso al que pertenece este prerrequisito
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // El curso que ES el prerrequisito
    public function prerequisite()
    {
        return $this->belongsTo(Course::class, 'prerequisite_course_id');
    }
}
