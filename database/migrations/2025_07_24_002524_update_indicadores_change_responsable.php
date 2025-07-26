<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIndicadoresChangeResponsable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('indicadores', 'id_usuario_responsable')) {
            Schema::table('indicadores', function (Blueprint $table) {
                $table->dropForeign(['id_usuario_responsable']);
                $table->dropColumn('id_usuario_responsable');
            });
        }

        if (Schema::hasColumn('indicadores', 'id_rol_responsable')) {
            Schema::table('indicadores', function (Blueprint $table) {
                // Cambiar tipo a unsignedInteger (int unsigned)
                $table->unsignedInteger('id_rol_responsable')->nullable()->change();
            });
        } else {
            Schema::table('indicadores', function (Blueprint $table) {
                $table->unsignedInteger('id_rol_responsable')->nullable()->after('id_alineacion');
            });
        }

        Schema::table('indicadores', function (Blueprint $table) {
            $table->foreign('id_rol_responsable')->references('IdRol')->on('rol')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('indicadores', function (Blueprint $table) {
            $table->dropForeign(['id_rol_responsable']);
            $table->dropColumn('id_rol_responsable');
        });

        if (!Schema::hasColumn('indicadores', 'id_usuario_responsable')) {
            Schema::table('indicadores', function (Blueprint $table) {
                $table->unsignedBigInteger('id_usuario_responsable')->nullable()->after('id_alineacion');
                $table->foreign('id_usuario_responsable')->references('IdUsuario')->on('usuarios')->onDelete('cascade');
            });
        }
    }
}

