<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudyPlan extends Model
{
    use HasFactory;

     protected $fillable = [
        'study_program_id', // A qué carrera pertenece este plan
        'name',             // Ej: 2019 (DCBN), 2010 (Plan Antiguo)
        'resolution_code',  // Ej: RVM Nº 163-2019-MINEDU
        'evaluation_type',  // vigesimal, competency (según PDF)
        'is_active',        // Si el plan está actualmente en uso
        'valid_from_year',  // Año desde el que es válido
        'valid_to_year',    // Año hasta el que es válido (nullable)
    ];

    public function program()
    {
        // Un plan pertenece a un programa (carrera)
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Un plan de estudio pertenece a un programa de estudio (carrera)
    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    // Un plan de estudio tiene muchos cursos
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Un plan de estudio puede tener muchas personas (alumnos) asociadas
    public function people()
    {
        return $this->hasMany(Person::class);
    }

    // Un plan de estudio puede tener sus propias escalas de notas
    public function gradeScales()
    {
        return $this->hasMany(GradeScale::class);
    }

    // Accessor para mostrar el nombre completo del plan
    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->studyProgram->short_name}) - {$this->resolution_code}";
    }
}
