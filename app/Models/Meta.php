<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Indicador;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'metas';

    protected $fillable = [
        'id_indicador',
        'anio',
        'valor_objetivo',
        'estado',
        'fecha_registro',
    ];

    // Relación con Indicador
    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'id_indicador');
    }
}
