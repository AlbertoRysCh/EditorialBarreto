<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmaclientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmaclientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idclientes')->unsigned();
            $table->foreign('idclientes')->references('id')->on('clientes');
            $table->unsignedBigInteger('idorden');
            $table->foreign('idorden')->references('idordentrabajo')->on('ordentrabajo');
            $table->string('archivo')->nullable();
            $table->string('condicion')->nullable();
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
        Schema::dropIfExists('firmaclientes');
    }
}
