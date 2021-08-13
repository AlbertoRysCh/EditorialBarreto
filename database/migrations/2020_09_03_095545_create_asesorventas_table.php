<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesorventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesorventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->string('num_documento')->nullable();
            $table->string('nombres')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('asesorventas')->insert([
            ['id' => '1',
            'usuario_id' => '2',
            'num_documento' => '0',
            'nombres' => 'AsesorVenta default',
            'telefono' => '000000000',
            'correo' => '',
            'zona_id' =>1,
            'condicion'=>1,
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
        Schema::dropIfExists('asesorventas');
    }
}
