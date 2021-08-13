<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateConfiguracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',30);
            $table->string('value',50);
            $table->string('description',200)->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
        DB::table('configuraciones')->insert(array(
            'id'=>'1',
            'code'=>'VERSION_APP',
            'value'=>'1.00',
            'description'=>NULL,
            'state'=>'1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()));
        DB::table('configuraciones')->insert(array(
            'id'=>'2',
            'code'=>'MANTENIMIENTO_WEB',
            'value'=>0,
            'description'=>'Activar/Desactivar modo mantenimiento la web',
            'state'=>'1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuraciones');
    }
}
