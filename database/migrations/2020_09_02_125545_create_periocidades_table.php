<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriocidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periocidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('periocidades')->insert(array('id'=>'1','nombre'=>'Trimestral','descripcion'=>'Correspondiente a 3 meses'));
        DB::table('periocidades')->insert(array('id'=>'2','nombre'=>'cuatrimestral','descripcion'=>'Correspondiente a 4 meses'));
        DB::table('periocidades')->insert(array('id'=>'3','nombre'=>'Semestral','descripcion'=>'Correspondiente a 6 meses'));
        DB::table('periocidades')->insert(array('id'=>'4','nombre'=>'Anual','descripcion'=>'Correspondiente a 1 Año'));
        DB::table('periocidades')->insert(array('id'=>'5','nombre'=>'Bimestral','descripcion'=>'Correspondiente a 2 meses'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periocidades');
    }
}
