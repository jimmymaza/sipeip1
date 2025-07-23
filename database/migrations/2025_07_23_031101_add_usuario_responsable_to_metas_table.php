<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuarioResponsableToMetasTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up()
    {
        Schema::table('metas', function (Blueprint $table) {
            // Cambiado a integer para que coincida con 'IdUsuario' que es int
            $table->integer('usuario_responsable_id')->nullable()->after('estado');

            // Clave foránea hacia la tabla usuarios con la columna correcta
            $table->foreign('usuario_responsable_id')
                  ->references('IdUsuario')
                  ->on('usuarios')
                  ->onDelete('set null');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down()
    {
        Schema::table('metas', function (Blueprint $table) {
            $table->dropForeign(['usuario_responsable_id']);
            $table->dropColumn('usuario_responsable_id');
        });
    }
}
