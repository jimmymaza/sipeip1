<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'IdRol';
    public $timestamps = true;

    protected $fillable = [
        'Nombre',
        'Descripcion',
    ];
}
