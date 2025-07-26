<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjetivoIdAndPlanIdToMetasTable extends Migration
{
    public function up()
    {
        Schema::table('metas', function (Blueprint $table) {
            // Solo agregar columna objetivo_id si no existe
            if (!Schema::hasColumn('metas', 'objetivo_id')) {
                $table->unsignedBigInteger('objetivo_id')->nullable()->after('id');
                $table->foreign('objetivo_id')
                      ->references('id')
                      ->on('objetivos_institucionales')  // <- Aquí está la corrección
                      ->onDelete('cascade');
            }

            // Solo agregar columna plan_id si no existe
            if (!Schema::hasColumn('metas', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('objetivo_id');
                $table->foreign('plan_id')
                      ->references('id')
                      ->on('planes')
                      ->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('metas', function (Blueprint $table) {
            if (Schema::hasColumn('metas', 'objetivo_id')) {
                $table->dropForeign(['objetivo_id']);
                $table->dropColumn('objetivo_id');
            }

            if (Schema::hasColumn('metas', 'plan_id')) {
                $table->dropForeign(['plan_id']);
                $table->dropColumn('plan_id');
            }
        });
    }
}
