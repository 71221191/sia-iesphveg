<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use  HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'username',
        'password',
        'email',
        'is_active',
        'must_change_password',
        'avatar_url',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación con la tabla People (RF-03.1)
    public function person()
    {
        return $this->hasOne(Person::class, 'user_id');
    }
}
