<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',50);
            $table->string('descripcion',100);
            $table->timestamps();
        });
        DB::table('parametros')->insert(array(
            'id'=>'1',
            'codigo'=>'MANTENIMIENTO_WEB',
            'descripcion'=>'0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()));
        DB::table('parametros')->insert(array(
            'id'=>'2',
            'codigo'=>'JEFE_ARTICULOS',
            'descripcion'=>'1',
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
        Schema::dropIfExists('parametros');
    }
}
