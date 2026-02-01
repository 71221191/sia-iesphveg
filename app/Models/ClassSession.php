<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    protected $fillable = ['course_section_id', 'date', 'topic', 'is_executed'];

    // Relación: Una sesión pertenece a una sección
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    // Relación: Una sesión tiene muchos registros de asistencia
    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
