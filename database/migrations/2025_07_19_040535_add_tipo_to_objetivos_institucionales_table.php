<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToObjetivosInstitucionalesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('objetivos_institucionales', function (Blueprint $table) {
            $table->string('tipo')->default('institucional')->after('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('objetivos_institucionales', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
