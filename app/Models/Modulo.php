<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    protected $primaryKey = 'IdModulo';

    // Cambia a false si no tienes columnas created_at y updated_at en la tabla
    public $timestamps = true;

    protected $fillable = [
        'Nombre',
        'Descripcion',
    ];

    /**
     * Relación muchos a muchos con Rol a través de la tabla pivote 'rol_modulo'
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'rol_modulo',
            'IdModulo', // foreign key del modelo actual (Modulo) en la tabla pivote
            'IdRol'     // foreign key del modelo relacionado (Rol) en la tabla pivote
        )->withPivot('AccesoCompleto');
    }
}
