<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('status')->insert(array('id'=>'1','nombre'=>'Análisis Bibliométrico','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'2','nombre'=>'En Proceso','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'3','nombre'=>'Culminado Por Asesor','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'4','nombre'=>'En espera de Habilitación','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'5','nombre'=>'Habilitado para Envío','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'6','nombre'=>'Corrección de Estilo','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'7','nombre'=>' Revision Interna','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'8','nombre'=>'Por Enviar a Editorial','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'9','nombre'=>'Enviado','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'10','nombre'=>'Revision por Pares','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'11','nombre'=>'Aceptado','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'12','nombre'=>'No asignado','descripcion'=>'Sin descripción'));
        DB::table('status')->insert(array('id'=>'13','nombre'=>'Publicado','descripcion'=>'Sin descripción'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
