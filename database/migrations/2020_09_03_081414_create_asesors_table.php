<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->string('num_documento')->nullable();
            $table->string('nombres')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->boolean('condicion')->default(1);
            $table->unsignedBigInteger('idtipoeditoriales');
            $table->foreign('idtipoeditoriales')->references('id')->on('tipoeditoriales'); 
            $table->timestamps();
        });
        DB::table('asesors')->insert([
            ['id' => '1',
            'usuario_id' => '3',
            'num_documento' => '0',
            'nombres' => 'No asignado',
            'telefono' => '000000000',
            'correo' => '',
            'condicion'=>1,
            'idtipoeditoriales'=>2,            
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asesors');
    }
}
