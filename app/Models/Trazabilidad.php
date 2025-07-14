<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Trazabilidad extends Model
{
    protected $table = 'trazabilidad';
    protected $primaryKey = 'IdTrazabilidad';
    public $timestamps = false;

    protected $fillable = [
        'EntidadAfectada',
        'IdEntidad',
        'Accion',
        'UsuarioResponsable',
        'Fecha',
    ];

    // Relación con usuario responsable
    public function usuarioResponsable()
    {
        return $this->belongsTo(User::class, 'UsuarioResponsable', 'Cedula');
    }
}
