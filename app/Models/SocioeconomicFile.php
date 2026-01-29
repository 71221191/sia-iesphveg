<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioeconomicFile extends Model
{
    protected $fillable = [
        'person_id',
        'academic_period_id',
        'has_children',
        'children_count',
        'scholarship_type_id',
        'is_validated',
        'housing_data' // Por si usas JSON en el futuro
    ];

    protected $casts = [
        'has_children' => 'boolean',
        'is_validated' => 'boolean',
        'housing_data' => 'array'
    ];
}
