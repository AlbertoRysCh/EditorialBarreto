<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->longText('titulo')->nullable();
            $table->integer('idarea')->unsigned();
            $table->foreign('idarea')->references('id')->on('areas');
            $table->unsignedBigInteger('idtipolibros');
            $table->foreign('idtipolibros')->references('id')->on('tipolibros');
            $table->unsignedBigInteger('idnivelibros');
            $table->foreign('idnivelibros')->references('id')->on('niveleslibros');
            $table->unsignedBigInteger('idasesor')->unsigned();
            $table->foreign('idasesor')->references('id')->on('asesors');
            $table->unsignedBigInteger('idusuario')->unsigned();
            $table->foreign('idusuario')->references('id')->on('users');
            $table->date('fechaOrden')->nullable();
            $table->date('fechaLlegada')->nullable();
            $table->date('fechaAsignacion')->nullable();
            $table->date('fechaAnalisis')->nullable();
            $table->date('fechaCulminacion')->nullable();
            $table->date('fechaRevisionInterna')->nullable();
            $table->date('fechaAprobacion')->nullable();
            $table->date('fechaEnvioPro')->nullable();
            $table->date('fechaHabilitacion')->nullable();
            $table->date('fechaEnvio')->nullable();
            $table->date('fechaAjustes')->nullable();
            $table->date('fechaIniCorre')->nullable();
            $table->date('fechaFinCorre')->nullable();
            $table->date('fechaAceptacion')->nullable();
            $table->date('fechaRechazo')->nullable();
            $table->unsignedBigInteger('idstatu');
            $table->foreign('idstatu')->references('id')->on('status');
            $table->unsignedBigInteger('idclasificacion');
            $table->foreign('idclasificacion')->references('id')->on('clasificaciones');
            $table->unsignedBigInteger('ideditorial');
            $table->foreign('ideditorial')->references('id')->on('editoriales');
            $table->unsignedBigInteger('idmodalidad');
            $table->foreign('idmodalidad')->references('id')->on('modalidades');
            $table->string('carta')->nullable();
            $table->string('usuario')->nullable();
            $table->string('contrasenna')->nullable();
            $table->string('pais')->nullable();
            $table->string('archivo')->nullable();
            $table->longText('observacion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->integer('step')->default(0);
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
        Schema::dropIfExists('libros');
    }
}
