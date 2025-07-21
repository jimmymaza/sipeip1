<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlineacionObjetivo extends Model
{
    protected $table = 'alineacion_objetivos';

    protected $fillable = [
        'objetivo_id',
        'objetivo_alineado_id',
        'tipo_alineacion', // Agregado para permitir asignación masiva
    ];

    // Relación con el objetivo base
    public function objetivo()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'objetivo_id');
    }

    // Relación con el objetivo alineado
    public function objetivoAlineado()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'objetivo_alineado_id');
    }
}
