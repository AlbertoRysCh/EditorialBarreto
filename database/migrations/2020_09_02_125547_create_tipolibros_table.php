<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipolibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipolibros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('tipolibros')->insert(array('id'=>'1','nombre'=>'Producción Foránea','descripcion'=>'Material de afuera'));
        DB::table('tipolibros')->insert(array('id'=>'2','nombre'=>'Innova Colaboradores','descripcion'=>'Coautoría'));
        DB::table('tipolibros')->insert(array('id'=>'3','nombre'=>'Innova Scientific Interno','descripcion'=>'Libros desde cero'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipolibros');
    }
}
