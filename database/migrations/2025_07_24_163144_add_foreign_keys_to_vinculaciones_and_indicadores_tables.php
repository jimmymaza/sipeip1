<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVinculacionesAndIndicadoresTables extends Migration
{
    public function up()
    {
        Schema::table('vinculaciones', function (Blueprint $table) {
            try {
                $table->foreign('objetivo_institucional_id', 'fk_vinculaciones_objetivo_institucional_id')
                    ->references('id')->on('objetivos_institucionales')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // Ya existe la clave o hay otro conflicto
            }

            try {
                $table->foreign('indicador_id', 'fk_vinculaciones_indicador_id')
                    ->references('id')->on('indicadores')
                    ->onDelete('set null');
            } catch (\Exception $e) {
                // Ya existe la clave o hay otro conflicto
            }
        });

        Schema::table('indicadores', function (Blueprint $table) {
            try {
                $table->foreign('id_alineacion', 'fk_indicadores_id_alineacion')
                    ->references('id')->on('vinculaciones')
                    ->onDelete('cascade');
            } catch (\Exception $e) {
                // Ya existe la clave o hay otro conflicto
            }
        });
    }

    public function down()
    {
        Schema::table('vinculaciones', function (Blueprint $table) {
            try {
                $table->dropForeign('fk_vinculaciones_objetivo_institucional_id');
            } catch (\Exception $e) {
                // Clave no existe
            }
            try {
                $table->dropForeign('fk_vinculaciones_indicador_id');
            } catch (\Exception $e) {
                // Clave no existe
            }
        });

        Schema::table('indicadores', function (Blueprint $table) {
            try {
                $table->dropForeign('fk_indicadores_id_alineacion');
            } catch (\Exception $e) {
                // Clave no existe
            }
        });
    }
}
