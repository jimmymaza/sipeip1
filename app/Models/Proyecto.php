<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyecto';

    protected $primaryKey = 'IdProyecto';

    public $timestamps = false;  // O usa created_at/updated_at si las tienes

    protected $fillable = [
        'NombreProyecto',
        'Estado',
        'FechaCreacion',
        'FechaActualizacion',
        'IdMeta',
        'IdRevision',
        'IdTrazabilidad',
    ];

    // Relación con Meta
    public function meta()
    {
        return $this->belongsTo(Meta::class, 'IdMeta', 'IdMeta');
    }

    // Relación con Revision
    public function revision()
    {
        return $this->belongsTo(Revision::class, 'IdRevision', 'IdRevision');
    }

    // Relación con Trazabilidad
    public function trazabilidad()
    {
        return $this->belongsTo(Trazabilidad::class, 'IdTrazabilidad', 'IdTrazabilidad');
    }
}
