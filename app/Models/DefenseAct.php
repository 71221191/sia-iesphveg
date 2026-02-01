<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefenseAct extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_project_id',
        'defense_date',
        'defense_time',
        'modality',
        'score',
        'result',
        'is_closed'
    ];

    // Para que Laravel trate las fechas correctamente
    protected $casts = [
        'defense_date' => 'date',
        'is_closed' => 'boolean'
    ];

    // Relación inversa: Un acta pertenece a un proyecto de tesis
    public function project()
    {
        return $this->belongsTo(ThesisProject::class, 'thesis_project_id');
    }
}
