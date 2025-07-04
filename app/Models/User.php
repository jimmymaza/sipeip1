<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'email',
        'rol',
        'password',
    ];

    /**
     * Atributos ocultos para arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
