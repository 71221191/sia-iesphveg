<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentDetail extends Model
{
    protected $fillable = [
        'enrollment_id',
        'course_id',
        'course_section_id',
        'final_score_numeric',
        'is_legacy',
        'status',
        'attempt_number'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
