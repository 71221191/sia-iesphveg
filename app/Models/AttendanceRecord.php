<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = ['class_session_id',
        'person_id',
        'status',
        'sync_status'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
