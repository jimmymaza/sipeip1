<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Agregar esta línea

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable, CanResetPasswordTrait, HasFactory;  // Agregar HasFactory aquí

    protected $table = 'usuarios';
    protected $primaryKey = 'IdUsuario';

    // Laravel por defecto espera timestamp created_at y updated_at, 
    // aquí ajustamos según tu esquema
    const CREATED_AT = 'FechaCreacion';
    const UPDATED_AT = null; // No tienes updated_at, por eso null

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

    // Ocultamos Clave para que no se exponga en JSON, etc.
    protected $hidden = [
        'Clave',
    ];

    /**
     * Laravel espera que el método getAuthPassword retorne el password
     * Aquí usamos tu columna 'Clave' en lugar de 'password'
     */
    public function getAuthPassword()
    {
        return $this->Clave;
    }

    /**
     * Para enviar el correo de restablecimiento de contraseña
     */
    public function getEmailForPasswordReset()
    {
        return $this->Correo;
    }

    /**
     * El identificador para autenticación es el correo
     */
    public function getAuthIdentifierName()
    {
        return 'Correo';
    }

    /**
     * Obtener valor del identificador
     */
    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    /**
     * Relación con Rol
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'IdRol', 'IdRol');
    }

    /**
     * Relación con Institución
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'IdInstitucion', 'IdInstitucion');
    }

    /**
     * Obtener nombres de módulos con acceso completo asignados al usuario por su rol
     *
     * @return array
     */
    public function modulosCompletos(): array
    {
        // Validar que rol esté cargado
        if (!$this->rol) {
            return [];
        }

        return $this->rol->modulos()
            ->wherePivot('AccesoCompleto', 1)
            ->pluck('Nombre')
            ->toArray();
    }

    /**
     * 
     *
     * @param string $nombreModulo
     * @return bool
     */
    public function tieneAccesoModulo(string $nombreModulo): bool
    {
        return in_array($nombreModulo, $this->modulosCompletos());
    }
}
