<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'modular_code', 
        'level', 
        'director_name', 
        'address', 
        'ubigeo_id', 
        'is_active'
    ];

    // --- AÑADE ESTA RELACIÓN ---
    public function ubigeo()
    {
        // Un centro de práctica pertenece a un distrito (Ubigeo)
        return $this->belongsTo(Ubigeo::class, 'ubigeo_id');
    }

    // También aprovechamos para dejar lista la relación de asignaciones
    public function assignments()
    {
        return $this->hasMany(PracticeAssignment::class);
    }
}