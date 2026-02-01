<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPortfolio extends Model
{
    protected $fillable = [
    'course_section_id', 'type', 'name', 'file_path', 'status', 'feedback', 'validated_by', 'validated_at'
    ];

    public function section() {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}
