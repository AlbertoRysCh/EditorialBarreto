<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idordentrabajo');
            $table->foreign('idordentrabajo')->references('idordentrabajo')->on('ordentrabajo');
            $table->date('fecha_cuota');
            $table->decimal('monto', 11, 2);
            $table->boolean('statu')->default(0);
            $table->string('capturepago')->nullable();
            $table->boolean('is_fee_init')->default(0);
            $table->boolean('tipo_contrato')->default(0);
            $table->bigInteger('contrato_id')->default(0);
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('cuotas');
    }
}
