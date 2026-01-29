<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    // Permitimos asignación masiva para estos campos
    protected $fillable = ['name', 'code', 'short_name'];

    // Relación: Una carrera tiene muchas mallas (StudyPlans)
    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }
    // Puedes añadir un accessor para un nombre más completo si necesitas
    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->short_name})";
    }
}
