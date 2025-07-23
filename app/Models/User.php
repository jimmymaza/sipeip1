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

    const CREATED_AT = 'FechaCreacion';
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

    // Sobrescribir para usar el campo 'Clave' como password
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

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    // Relación con Rol (modelo Rol debe existir)
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'IdRol', 'IdRol');
    }

    // Relación con Institucion (modelo Institucion debe existir)
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'IdInstitucion', 'IdInstitucion');
    }

    /**
     * Obtener los nombres de módulos con acceso completo asignados al usuario por su rol
     *
     * @return array
     */
    public function modulosCompletos(): array
    {
        if (!$this->rol) {
            return [];
        }

        return $this->rol->modulos()
            ->wherePivot('AccesoCompleto', 1)  // asumiendo boolean en BD
            ->pluck('Nombre')
            ->toArray();
    }

    /**
     * Verificar si el usuario tiene acceso a un módulo específico
     *
     * @param string $nombreModulo
     * @return bool
     */
    public function tieneAccesoModulo(string $nombreModulo): bool
    {
        return in_array($nombreModulo, $this->modulosCompletos());
    }
}
