<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';
    protected $primaryKey = 'IdPlan';
    public $timestamps = false;

    protected $fillable = [
        'NombrePlan',
        'Descripcion',
        'FechaCreacion',
        'Estado',
        'IdUsuario', // ¿Este campo es para autor o responsable?
        'Cedula',   // Relacionado a Usuario
        'IdRevision',
        // No incluyo IdObjetivo porque tienes varios tipos
    ];

    // Relación con Usuario (responsable o creador)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'Cedula', 'Cedula');
    }

    // Relación con Revision
    public function revision()
    {
        return $this->belongsTo(Revision::class, 'IdRevision', 'IdRevision');
    }

    // Relación con Objetivos Institucionales (múltiples)
    public function objetivosInstitucionales()
    {
        return $this->hasMany(ObjetivoInstitucional::class, 'IdPlan', 'IdPlan');
    }

    // Relación con Objetivos PND (múltiples)
    public function objetivosPND()
    {
        return $this->hasMany(ObjetivoPND::class, 'IdPlan', 'IdPlan');
    }

    // Relación con Objetivos ODS (múltiples)
    public function objetivosODS()
    {
        return $this->hasMany(ObjetivoODS::class, 'IdPlan', 'IdPlan');
    }
}
