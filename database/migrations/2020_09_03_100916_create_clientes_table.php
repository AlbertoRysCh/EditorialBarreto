<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_documento',250)->nullable();
            $table->string('codigo',100)->nullable();
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
            $table->boolean('autor');
            $table->foreign('idgrado')->references('id')->on('grados');
            $table->unsignedBigInteger('aviso_id');
            $table->foreign('aviso_id')->references('id')->on('avisos');
            $table->unsignedBigInteger('asesor_venta_id');
            $table->foreign('asesor_venta_id')->references('id')->on('asesorventas');
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            /*$table->unsignedBigInteger('productos_id');
            $table->foreign('productos_id')->references('id')->on('tipoeditoriales');*/
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
        Schema::dropIfExists('clientes');
    }
}
