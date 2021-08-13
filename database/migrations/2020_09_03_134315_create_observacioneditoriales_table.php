<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacioneditorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacioneditoriales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idlibro');
            $table->foreign('idlibro')->references('id')->on('libros');
            $table->longText('descripcion')->nullable();
            $table->string('archivo')->nullable();
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
        Schema::dropIfExists('observacioneditoriales');
    }
}
