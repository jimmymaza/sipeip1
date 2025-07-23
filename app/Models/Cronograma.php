<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;

    // Definir nombre explícito de la tabla, en caso que no siga la convención Laravel
    protected $table = 'cronogramas';

    // Campos asignables masivamente
    protected $fillable = [
        'plan_id',
        'programa_id',
        'proyecto_id',
        'actividad',
        'fecha_inicio',
        'fecha_fin',
        'responsable',
        'estado',
        'observaciones',
    ];

    /**
     * Relación: Un Cronograma pertenece a un Plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Relación: Un Cronograma pertenece a un Programa
     */
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'programa_id');
    }

    /**
     * Relación: Un Cronograma pertenece a un Proyecto
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}
