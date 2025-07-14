<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'meta';
    protected $primaryKey = 'IdMeta';
    public $timestamps = false;

    protected $fillable = [
        'Descripcion',
        'FechaInicio',
        'FechaFin',
        'IdObjetivoInstitucional', // FK para objetivo institucional
        'IdObjetivoPND',           // FK para objetivo PND
        'IdObjetivoODS',           // FK para objetivo ODS
        'IdProyecto',
    ];

    // Relación con Objetivo Institucional
    public function objetivoInstitucional()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'IdObjetivoInstitucional', 'IdObjetivo');
    }

    // Relación con Objetivo PND
    public function objetivoPND()
    {
        return $this->belongsTo(ObjetivoPND::class, 'IdObjetivoPND', 'IdObjetivo');
    }

    // Relación con Objetivo ODS
    public function objetivoODS()
    {
        return $this->belongsTo(ObjetivoODS::class, 'IdObjetivoODS', 'IdObjetivo');
    }

    // Relación con Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'IdProyecto', 'IdProyecto');
    }
}
