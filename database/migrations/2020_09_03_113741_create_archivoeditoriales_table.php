<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivoeditorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivoeditoriales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idlibro');
            $table->foreign('idlibro')->references('id')->on('libros');
            $table->unsignedBigInteger('iduser');
            $table->foreign('iduser')->references('id')->on('users')->cascade();
            $table->string('archivo')->nullable();
            $table->string('avance')->nullable();
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
        Schema::dropIfExists('archivoeditoriales');
    }
}
