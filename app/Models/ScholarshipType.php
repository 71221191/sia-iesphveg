<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipType extends Model
{
    // Esto permite que el importador cree becas nuevas automáticamente
    protected $fillable = ['name'];
    public $timestamps = false; // Las tablas catálogo suelen no necesitar timestamps, pero si tu migración los tiene, borra esta línea.
}
