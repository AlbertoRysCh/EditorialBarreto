<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',100);
            $table->string('nombre',100);
            $table->string('descripcion',150)->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
        DB::table('avisos')->insert(array('id'=>'1','codigo'=>'01234','nombre'=>'Facebook','descripcion'=>'Facebook'));
        DB::table('avisos')->insert(array('id'=>'2','codigo'=>'56789','nombre'=>'Whatsapp','descripcion'=>'Whatsapp'));
        DB::table('avisos')->insert(array('id'=>'3','codigo'=>'02254','nombre'=>'Correo','descripcion'=>'Correo'));
        DB::table('avisos')->insert(array('id'=>'4','codigo'=>'36365','nombre'=>'Noticias','descripcion'=>'Noticias'));
        DB::table('avisos')->insert(array('id'=>'5','codigo'=>'85476','nombre'=>'Aviso','descripcion'=>'Aviso'));
        DB::table('avisos')->insert(array('id'=>'6','codigo'=>'99874','nombre'=>'Amigo','descripcion'=>'Amigo'));
        DB::table('avisos')->insert(array('id'=>'7','codigo'=>'45693','nombre'=>'Otro','descripcion'=>'Otro'));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avisos');
    }
}
