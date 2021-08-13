<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->longText('titulo')->nullable();
            $table->unsignedBigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->integer('idclientes')->unsigned();
            $table->foreign('idclientes')->references('id')->on('clientes');
            $table->unsignedBigInteger('idnivelibros');
            $table->foreign('idnivelibros')->references('id')->on('niveleslibros');
            $table->unsignedBigInteger('idtipoeditoriales');
            $table->foreign('idtipoeditoriales')->references('id')->on('tipoeditoriales');
            $table->string('puntaje')->nullable();
            $table->longText('observaciones')->nullable();
            $table->string('archivo')->nullable();
            $table->string('archivoevaluador')->nullable();
            $table->boolean('condicion')->default(1);
            $table->boolean('estado_revision')->default(0);
            $table->bigInteger('revisado_por')->nullable();
            $table->bigInteger('contrato_id')->default(0);
            $table->boolean('parent')->default(0);
            $table->bigInteger('decision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revisiones');
    }
}
