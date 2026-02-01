<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesisJuror extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_project_id',
        'teacher_id',
        'role' // presidente, secretario, vocal
    ];

    // Relación con el proyecto de tesis
    public function project()
    {
        return $this->belongsTo(ThesisProject::class, 'thesis_project_id');
    }

    // Relación con el docente (que es una persona)
    public function teacher()
    {
        return $this->belongsTo(Person::class, 'teacher_id');
    }
}
