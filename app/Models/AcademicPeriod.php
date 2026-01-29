<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status', // planning, open, closed
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Puedes añadir relaciones si los períodos tienen asociaciones
    // Por ejemplo, con course_sections:
    public function courseSections()
    {
        return $this->hasMany(CourseSection::class);
    }

    // Y con enrollments:
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
