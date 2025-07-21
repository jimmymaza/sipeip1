<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoAlineacionToAlineacionObjetivosTable extends Migration
{
    public function up()
    {
        Schema::table('alineacion_objetivos', function (Blueprint $table) {
            $table->string('tipo_alineacion')->after('objetivo_alineado_id')->nullable()->comment('Tipo de alineación: ej. institucional-pnd');
        });
    }

    public function down()
    {
        Schema::table('alineacion_objetivos', function (Blueprint $table) {
            $table->dropColumn('tipo_alineacion');
        });
    }
}
