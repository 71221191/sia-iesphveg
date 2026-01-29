<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $fillable = ['code', 'department', 'province', 'district'];
    public $timestamps = false;
}
