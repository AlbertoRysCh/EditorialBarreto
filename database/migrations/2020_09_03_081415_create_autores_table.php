<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_documento',250)->nullable();
            // $table->bigInteger('num_documento')->nullable()->unsigned();
            $table->string('num_documento',20)->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('correocontacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correogmail')->nullable();
            $table->string('contrasena')->nullable();
            $table->string('resumen')->nullable();
            $table->string('orcid')->nullable();
            $table->string('universidad')->nullable();
            $table->integer('idgrado')->unsigned();
            $table->string('especialidad')->nullable();
            $table->boolean('condicion')->default(1);
            $table->foreign('idgrado')->references('id')->on('grados');
            $table->rememberToken();
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
        Schema::dropIfExists('autores');
    }
}
