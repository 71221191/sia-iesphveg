<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth; // <--- 1. ESTA SOLUCIONA LO DE 'AUTH'
use Inertia\Inertia;                // <--- 2. ESTA SOLUCIONA LO DE 'INERTIA'
use Illuminate\Database\Eloquent\Model;

class ThesisProject extends Model
{
    protected $fillable = ['title', 'research_line', 'advisor_id', 'status', 'is_imported'];

    // Relación con los autores (Alumnos)
    public function authors() {
        return $this->belongsToMany(Person::class, 'thesis_authors', 'thesis_project_id', 'student_id');
    }

    public function index()
    {
        $person = Auth::user()->person;

        // AÑADIMOS 'defenseAct' al load para traer la nota y el resultado
        $myProject = $person->thesisProjects()
            ->with(['authors', 'advisor', 'jurors.teacher', 'defenseAct'])
            ->first();

        return Inertia::render('Student/Thesis/Index', [
            'project' => $myProject
        ]);
    }

    // Relación con el Asesor (Docente)
    public function advisor() {
        return $this->belongsTo(Person::class, 'advisor_id');
    }

    // Relación con los Jurados
    public function jurors() {
        return $this->hasMany(ThesisJuror::class);
    }

    public function documents()
    {
        // Asegúrate de que el nombre sea ThesisDocument (con S y con U)
        return $this->hasMany(ThesisDocument::class);
    }

    public function defenseAct()
    {
        return $this->hasOne(DefenseAct::class);
    }
}
