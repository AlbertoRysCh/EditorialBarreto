<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clasificaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('clasificaciones')->insert(array('id'=>'1','nombre'=>'No Asignado','descripcion'=>'Sin descripción'));
        DB::table('clasificaciones')->insert(array('id'=>'2','nombre'=>'Libro Inv. Nuevo','descripcion'=>'Sin descripción'));
        DB::table('clasificaciones')->insert(array('id'=>'3','nombre'=>'Publicado','descripcion'=>'Sin descripción'));
        DB::table('clasificaciones')->insert(array('id'=>'4','nombre'=>'Redireccionamiento','descripcion'=>'Sin descripción'));
        DB::table('clasificaciones')->insert(array('id'=>'5','nombre'=>'Ajustes','descripcion'=>'Sin descripción'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clasificaciones');
    }
}
