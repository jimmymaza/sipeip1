<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';            // Nombre de la tabla en BD
    protected $primaryKey = 'IdRol';     // Llave primaria personalizada
    public $timestamps = false;          // No usa timestamps

    protected $fillable = [
        'Nombre',
        'Descripcion',
    ];

    /**
     * Relación muchos a muchos con Modulo (tabla pivote 'rol_modulo')
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modulos()
    {
        return $this->belongsToMany(
            Modulo::class,          // Modelo relacionado
            'rol_modulo',           // Tabla pivote
            'IdRol',                // Foreign key de este modelo en la tabla pivote
            'IdModulo'              // Foreign key del modelo relacionado en la tabla pivote
        )->withPivot('AccesoCompleto');    // Campo extra en la tabla pivote
    }
}
