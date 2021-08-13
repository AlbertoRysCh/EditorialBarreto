<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreoslibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correoslibros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idcliente')->unsigned();
            $table->foreign('idcliente')->references('id')->on('clientes');
            $table->string('codigolib')->unique();
            $table->foreign('codigolib')->references('codigo')->on('ordentrabajo');
            $table->string('correo');
            $table->string('contrasena');
            $table->string('celularrelacionado');
            $table->string('firma');
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
        Schema::dropIfExists('correoslibros');
    }
}
