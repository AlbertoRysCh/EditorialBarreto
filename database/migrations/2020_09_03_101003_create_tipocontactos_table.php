<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipocontactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipocontactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });

        DB::table('tipocontactos')->insert(array('id'=>'1','nombre'=>'Correo','descripcion'=>'Sin descripción'));
        DB::table('tipocontactos')->insert(array('id'=>'2','nombre'=>'Llamada','descripcion'=>'Sin descripción'));
    
        DB::table('tipocontactos')->insert(array('id'=>'3','nombre'=>'Whatsapp','descripcion'=>'Sin descripción'));
        DB::table('tipocontactos')->insert(array('id'=>'4','nombre'=>'No Asignado','descripcion'=>'Sin descripción'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipocontactos');
    }
}
