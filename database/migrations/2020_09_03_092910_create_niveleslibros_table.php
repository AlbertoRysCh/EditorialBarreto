<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiveleslibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveleslibros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('niveleslibros')->insert(array('id'=>'1','nombre'=>'Nivel I','descripcion'=>'Puntaje menor de 40'));
        DB::table('niveleslibros')->insert(array('id'=>'2','nombre'=>'Nivel II','descripcion'=>'Puntaje entre 40 y 80'));
        DB::table('niveleslibros')->insert(array('id'=>'3','nombre'=>'Nivel III','descripcion'=>'Puntaje mayor de 80s'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('niveleslibros');
    }
}
