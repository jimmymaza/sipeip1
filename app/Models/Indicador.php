<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    protected $table = 'indicadores';

    // La tabla no tiene timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables masivamente
    protected $fillable = [
        'id_alineacion',
        'codigo',
        'nombre',
        'descripcion',
        'unidad_medida',
        'estado',
        'fecha_registro',
    ];

    // Cast para manejar fecha_registro como instancia Carbon
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    // Relación: un indicador pertenece a una vinculacion
    public function vinculacion()
    {
        return $this->belongsTo(Vinculacion::class, 'id_alineacion');
    }

    // Relación: un indicador tiene muchas metas
    public function metas()
    {
        return $this->hasMany(Meta::class, 'id_indicador');
    }
}
