<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Un plan puede tener muchas metas
    public function metas()
    {
        return $this->hasMany(Meta::class, 'plan_id');
    }

    // Un plan pertenece a muchos objetivos institucionales
    public function objetivos()
    {
        return $this->belongsToMany(ObjetivoInstitucional::class, 'objetivo_plan', 'plan_id', 'objetivo_id');
    }

    // Relación con proyectos (opcional)
    // public function proyectos()
    // {
    //     return $this->hasMany(Proyecto::class, 'plan_id');
    // }
}
