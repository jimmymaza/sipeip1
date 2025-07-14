<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoODS extends Model
{
    protected $table = 'objetivos_ods';

    protected $fillable = [
        'numero',
        'nombre',
        'descripcion',
    ];

    // Relación muchos a muchos con ObjetivoInstitucional
    public function objetivosInstitucionales()
    {
        return $this->belongsToMany(
            ObjetivoInstitucional::class,
            'alineacion_objetivos',
            'objetivo_ods_id',
            'objetivo_institucional_id'
        );
    }
}
