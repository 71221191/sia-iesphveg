<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseSection;

class Course extends Model
{
    use HasFactory;

    // Estos son los campos que el importador de Excel necesita permiso para llenar
    protected $fillable = [
        'study_plan_id',
        'code',
        'name',
        'cycle',
        'credits',
        'hours_theory',
        'hours_practice',
        'type',
        'is_legacy'
    ];

    protected $casts = [
        'is_legacy' => 'boolean',
        'credits' => 'decimal:2', // Asegúrate de que los créditos se manejen como decimales
    ];

    // Relación: Un curso pertenece a un Plan de Estudios
    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    // --- NUEVA RELACIÓN: Prerrequisitos ---
    public function prerequisites()
    {
        // Un curso puede tener muchos otros cursos como prerrequisito
        return $this->hasMany(CoursePrerequisite::class, 'course_id');
    }

    // También, un curso puede ser prerrequisito de otros cursos
    public function isPrerequisiteFor()
    {
        return $this->hasMany(CoursePrerequisite::class, 'prerequisite_course_id');
    }

    public function competencies()
    {
        return $this->belongsToMany(Competency::class, 'course_competency')
                    ->withPivot('weight');

    }
}
