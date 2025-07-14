<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlineacionObjetivo extends Model
{
    use HasFactory;

    protected $table = 'alineacion_objetivos';

    protected $fillable = [
        'objetivo_institucional_id',
        'objetivo_pnd_id',
        'objetivo_ods_id',
    ];

    public function objetivoInstitucional()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'objetivo_institucional_id');
    }

    public function objetivoPND()
    {
        return $this->belongsTo(ObjetivoPND::class, 'objetivo_pnd_id');
    }

    public function objetivoODS()
    {
        return $this->belongsTo(ObjetivoODS::class, 'objetivo_ods_id');
    }
}
