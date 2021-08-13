<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoautoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coautores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_articulo');
            $table->json('cliente')->nullable();
            $table->boolean('condicion')->default(2);
            $table->bigInteger('contrato_id')->default(0);
            $table->boolean('estado_pago')->default(0);
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
        Schema::dropIfExists('coautores');
    }
}
