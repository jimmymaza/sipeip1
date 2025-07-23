<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculacion extends Model
{
    use HasFactory;

    protected $table = 'vinculaciones';

    protected $fillable = [
        'tipo',
        'nombre',
        'descripcion',
        'objetivo_institucional_id',
        'indicador_id',
        'meta_id',
        'usuario_id',
    ];

    // Relaciones

    public function objetivoInstitucional()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'objetivo_institucional_id');
    }

    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'indicador_id');
    }

    public function meta()
    {
        return $this->belongsTo(Meta::class, 'meta_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
