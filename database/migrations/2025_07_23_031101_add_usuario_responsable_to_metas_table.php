<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuarioResponsableToMetasTable extends Migration
{
    public function up()
    {
        Schema::table('metas', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_responsable_id')->nullable()->after('estado');

            $table->foreign('usuario_responsable_id')
                  ->references('IdUsuario')
                  ->on('usuarios')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('metas', function (Blueprint $table) {
            $table->dropForeign(['usuario_responsable_id']);
            $table->dropColumn('usuario_responsable_id');
        });
    }
}
