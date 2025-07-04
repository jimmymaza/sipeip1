<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    // Nombre exacto de la tabla (según tu script SQL)
    protected $table = 'Rol';

    // Clave primaria personalizada
    protected $primaryKey = 'idRol';

    // Laravel espera por defecto "created_at" y "updated_at"
    // Si no usas esos campos, desactiva timestamps
    public $timestamps = false;

    // Campos que se pueden asignar masivamente (fillable)
    protected $fillable = [
        'nombreRol',
        'descripcion',
    ];
}
