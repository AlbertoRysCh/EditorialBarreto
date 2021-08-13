<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modalidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('modalidades')->insert(array('id'=>'1','nombre'=>'Plataforma','descripcion'=>'Correspondiente a Plataforma'));
        DB::table('modalidades')->insert(array('id'=>'2','nombre'=>'Correo','descripcion'=>'Correspondiente a Correo'));
        DB::table('modalidades')->insert(array('id'=>'3','nombre'=>'No Asignado','descripcion'=>NULL));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modalidades');
    }
}
