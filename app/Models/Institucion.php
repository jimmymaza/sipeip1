<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';   // Nombre correcto de la tabla
    protected $primaryKey = 'IdInstitucion'; // Clave primaria personalizada
    public $timestamps = false;  // Cambia a true si tienes campos created_at y updated_at

    protected $fillable = [
        'Nombre',
        'Codigo',
        'Subsector',
        'NivelGobierno',
        'Estado',
    ];
}
