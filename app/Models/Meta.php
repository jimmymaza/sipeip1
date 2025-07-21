<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'metas';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'objetivo_id',
        'plan_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Relación con Objetivo Institucional
    public function objetivo()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'objetivo_id');
    }

    // Relación con Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
