<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialcorreoseditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historialcorreosedit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idlibro');
            $table->foreign('idlibro')->references('id')->on('libros');  
            $table->integer('idclientes')->unsigned();
            $table->foreign('idclientes')->references('id')->on('clientes');
            $table->string('archivo');
            $table->date('fecha_correo');
            $table->longText('observacion')->nullable();
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
        Schema::dropIfExists('historialcorreosedit');
    }
}
