<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoPND extends Model
{
    protected $table = 'objetivos_pnd';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'eje',
    ];

    // Relación muchos a muchos con ObjetivoInstitucional
    public function objetivosInstitucionales()
    {
        return $this->belongsToMany(
            ObjetivoInstitucional::class,
            'alineacion_objetivos',
            'objetivo_pnd_id',
            'objetivo_institucional_id'
        );
    }
}
