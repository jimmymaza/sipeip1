<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Agregado para usar factories

class Meta extends Model
{
    use HasFactory;  // Agregado para usar factories

    protected $table = 'metas';

    // Llena los campos que permiten asignación masiva (mass assignment)
    protected $fillable = [
        'objetivo_id',
        'plan_id',
        'id_indicador',
        'anio',
        'valor_objetivo',
        'estado',
        'usuario_responsable_id',
        'fecha_registro',
    ];

    // Si tu tabla no tiene timestamps created_at y updated_at
    public $timestamps = false;

    // Relación con indicador
    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'id_indicador');
    }

    // Relación con usuario responsable
    public function responsable()
    {
        // Verifica que el modelo User está correctamente importado
        // Además, aquí el tercer parámetro es la clave primaria en la tabla User (usualmente 'id')
        // Si en tu tabla usuarios la PK es 'IdUsuario', entonces está bien así:
        return $this->belongsTo(User::class, 'usuario_responsable_id', 'IdUsuario');
    }

    // Relación con plan
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    // Si tienes modelo para objetivos institucionales y quieres relacionarlo, sería bueno agregar:
    public function objetivo()
    {
        return $this->belongsTo(ObjetivoInstitucional::class, 'objetivo_id');
    }
}
