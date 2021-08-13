<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class CreateZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
         //CREACION DE ZONAS POR DEFECTO
         DB::table('zonas')->insert([
            ['id' => '1',  'nombre' => 'LIMA','descripcion'=> 'LIMA','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            ['id' => '2',  'nombre' => 'NORTE','descripcion'=> 'NORTE','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            ['id' => '3',  'nombre' => 'SUR','descripcion'=> 'SUR','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            ['id' => '4',  'nombre' => 'SIERRA CENTRAL','descripcion'=> 'SIERRA CENTRAL','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            ['id' => '5',  'nombre' => 'NOR ESTE','descripcion'=> 'NOR ESTE','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            ['id' => '6',  'nombre' => 'SUR ESTE','descripcion'=> 'SUR ESTE','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
            ['id' => '7',  'nombre' => 'DEFAULT','descripcion'=> 'DEFAULT','created_at' => Carbon::now(),
            'updated_at' => Carbon::now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zonas');
    }
}
