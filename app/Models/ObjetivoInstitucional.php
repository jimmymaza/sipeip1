<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjetivoInstitucional extends Model
{
    protected $table = 'objetivos_institucionales';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'fecha_registro',
        'tipo', // puede ser: institucional, pnd, ods
    ];

    // Relación uno a muchos con metas
    public function metas()
    {
        return $this->hasMany(Meta::class, 'objetivo_id');
    }

    // Relación muchos a muchos con planes
    public function planes()
    {
        return $this->belongsToMany(
            Plan::class,
            'objetivo_plan',
            'objetivo_id',
            'plan_id'
        );
    }

    /**
     * Scope local para filtrar objetivos por tipo
     * Uso: ObjetivoInstitucional::tipo('ods')->get();
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Objetivos alineados (hijos)
     * Podrías filtrar por tipo_alineacion si lo necesitas
     */
    public function alineados()
    {
        return $this->belongsToMany(
            ObjetivoInstitucional::class,
            'alineacion_objetivos',
            'objetivo_id',
            'objetivo_alineado_id'
        );
    }

    /**
     * Objetivos que alinean a este (padres)
     */
    public function alineadoPor()
    {
        return $this->belongsToMany(
            ObjetivoInstitucional::class,
            'alineacion_objetivos',
            'objetivo_alineado_id',
            'objetivo_id'
        );
    }
}
