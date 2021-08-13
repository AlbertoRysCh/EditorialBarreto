<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoeditorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoeditoriales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        /*DB::table('tipoeditoriales')->insert(array('id'=>'1','nombre'=>'No Asignado','descripcion'=>'Sin descripción'));*/
        DB::table('tipoeditoriales')->insert(array('id'=>'1','nombre'=>'Libro de Investigación','descripcion'=>'Sin descripción'));
        DB::table('tipoeditoriales')->insert(array('id'=>'2','nombre'=>'Libro Académico','descripcion'=>'Sin descripción'));

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoeditoriales');
    }
}
