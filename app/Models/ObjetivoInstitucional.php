<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoInstitucional extends Model
{
    protected $table = 'objetivos_institucionales';

    protected $fillable = [
        'descripcion',
        'fecha_registro',
        'estado',
    ];

    protected $dates = ['fecha_registro'];

    // Relación muchos a muchos con ObjetivoPND
    public function pnds()
    {
        return $this->belongsToMany(
            ObjetivoPND::class,
            'alineacion_objetivos',
            'objetivo_institucional_id',
            'objetivo_pnd_id'
        );
    }

    // Relación muchos a muchos con ObjetivoODS
    public function ods()
    {
        return $this->belongsToMany(
            ObjetivoODS::class,
            'alineacion_objetivos',
            'objetivo_institucional_id',
            'objetivo_ods_id'
        );
    }
}
