<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion',100)->nullable();
            $table->boolean('condicion')->default(1);
        });
        DB::table('grados')->insert(array('id'=>'1','codigo'=>'G1','nombre'=>'Maestria','descripcion'=>'Correspondiente a Plataforma'));
        DB::table('grados')->insert(array('id'=>'2','codigo'=>'G2','nombre'=>'Doctor','descripcion'=>'Correspondiente a los grado Doctor'));
        DB::table('grados')->insert(array('id'=>'3','codigo'=>'G3','nombre'=>'Postdoctor','descripcion'=>'Correspondiente a los grado Postdoctor'));
        DB::table('grados')->insert(array('id'=>'4','codigo'=>'G4','nombre'=>'Bachiller','descripcion'=>'Correspondiente al grado Bachiller'));
        DB::table('grados')->insert(array('id'=>'5','codigo'=>'NA','nombre'=>'No aplica','descripcion'=>'No aplica'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grados');
    }
}
