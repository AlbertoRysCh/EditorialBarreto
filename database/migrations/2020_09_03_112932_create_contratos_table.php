<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->uuid('uuid');
            $table->longText('titulo_contrato')->nullable();
            $table->json('cliente')->nullable();
            $table->boolean('check_cuotas')->default(false);
            $table->json('num_cuotas');
            $table->decimal('precio_cuotas',11,2);
            $table->decimal('monto_inicial',11,2);
            $table->decimal('monto_total',11,2);
            $table->boolean('condicion')->default(1);
            $table->boolean('has_ot')->default(0);
            $table->boolean('tipo_contrato')->default(0);
            $table->string('observaciones')->nullable();
            $table->string('archivo_contrato')->nullable();
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
        Schema::dropIfExists('contratos');
    }
}
