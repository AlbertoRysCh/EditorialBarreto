<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNivelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('niveles')->insert(array('id'=>'1','nombre'=>'Scopus','descripcion'=>'Correspondiente a Scopus'));
        DB::table('niveles')->insert(array('id'=>'2','nombre'=>'WoS','descripcion'=>'Correspondiente a WoS'));
        DB::table('niveles')->insert(array('id'=>'3','nombre'=>'SCielO','descripcion'=>'Correspondiente a SCielO'));
        DB::table('niveles')->insert(array('id'=>'4','nombre'=>'No Asignado','descripcion'=>'Correspondiente a No Asignados'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('niveles');
    }
}
