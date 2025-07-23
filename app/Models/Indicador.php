<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    use HasFactory;

    protected $table = 'indicadores';

    protected $fillable = [
        'id_alineacion', // ID que referencia la vinculación o alineación
        'codigo',
        'nombre',
        'descripcion',
        'unidad_medida',
        'estado',
        'fecha_registro',
    ];

    // Un Indicador puede tener muchas Metas
    public function metas()
    {
        return $this->hasMany(Meta::class, 'id_indicador');
    }

    // Un Indicador pertenece a una Vinculación o Alineación
    // Si 'id_alineacion' referencia a una tabla vinculaciones, usar Vinculacion::class
    public function vinculacion()
    {
        return $this->belongsTo(Vinculacion::class, 'id_alineacion');
    }
}
