<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Un dominio tiene muchas competencias
    public function competencies()
    {
        return $this->hasMany(Competency::class);
    }
}
