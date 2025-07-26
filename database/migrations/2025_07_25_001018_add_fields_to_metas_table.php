<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMetasTable extends Migration
{
    public function up()
    {
        Schema::table('metas', function (Blueprint $table) {

            if (!Schema::hasColumn('metas', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('objetivo_id');
                $table->foreign('plan_id')->references('id')->on('planes')->onDelete('set null');
            }

            if (!Schema::hasColumn('metas', 'usuario_responsable_id')) {
                $table->unsignedBigInteger('usuario_responsable_id')->nullable()->after('plan_id');
                $table->foreign('usuario_responsable_id')->references('IdUsuario')->on('usuarios')->onDelete('set null');
            }

            // No agregamos foreign key para objetivo_id aquí porque ya fue creada en otra migración
        });
    }

    public function down()
    {
        Schema::table('metas', function (Blueprint $table) {

            $connection = Schema::getConnection();
            $sm = $connection->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails($connection->getTablePrefix() . 'metas');

            if ($doctrineTable->hasForeignKey('metas_plan_id_foreign')) {
                $table->dropForeign(['plan_id']);
            }
            if ($doctrineTable->hasForeignKey('metas_usuario_responsable_id_foreign')) {
                $table->dropForeign(['usuario_responsable_id']);
            }
            // No tocamos la foreign key objetivo_id porque no la creamos aquí

            if (Schema::hasColumn('metas', 'plan_id')) {
                $table->dropColumn('plan_id');
            }
            if (Schema::hasColumn('metas', 'usuario_responsable_id')) {
                $table->dropColumn('usuario_responsable_id');
            }
        });
    }
}
