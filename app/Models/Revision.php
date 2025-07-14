<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'revision';
    protected $primaryKey = 'IdRevision';
    public $timestamps = false;

    protected $fillable = [
        'Comentario',
        'FechaRevision',
        'IdUsuario',
        'IdPlan',
        'IdProyecto',
    ];

    // Relación con Usuario (modelo User)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario', 'Cedula');
    }

    // Relación con Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'IdPlan', 'IdPlan');
    }

    // Relación con Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'IdProyecto', 'IdProyecto');
    }
}
