<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'plan_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
