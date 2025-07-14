<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable, CanResetPasswordTrait;

    protected $table = 'usuarios';

    protected $primaryKey = 'IdUsuario';

    // Solo usa 'FechaCreacion' como timestamp de creación
    const CREATED_AT = 'FechaCreacion';

    // Desactiva el timestamp de actualización para evitar errores
    const UPDATED_AT = null;

    public $timestamps = true;

    protected $fillable = [
        'Cedula',
        'Nombre',
        'Apellido',
        'Correo',
        'Telefono',
        'Clave',
        'IdInstitucion',
        'IdRol',
    ];

    protected $hidden = [
        'Clave',
    ];

    public function getAuthPassword()
    {
        return $this->Clave;
    }

    public function getEmailForPasswordReset()
    {
        return $this->Correo;
    }

    public function getAuthIdentifierName()
    {
        return 'Correo';
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'IdRol', 'IdRol');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'IdInstitucion', 'IdInstitucion');
    }
}
