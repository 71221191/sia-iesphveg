<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    use HasFactory;

    protected $fillable = ['domain_id', 'code', 'description'];

    // Una competencia pertenece a un dominio
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    // Un curso puede tener muchas competencias asignadas
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_competency')
                    ->withPivot('weight');
    }
}
