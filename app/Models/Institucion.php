<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Agregado HasFactory

class Institucion extends Model
{
    use HasFactory;  // Usar el trait HasFactory

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

    // Cast para que Estado se maneje como booleano (true/false)
    protected $casts = [
        'Estado' => 'boolean',
    ];
}
