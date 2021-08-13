<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class CreateEditorialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editoriales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->mediumText('lineaInvestigacion')->nullable();
            $table->string('idioma')->nullable();
            $table->string('pais')->nullable();
            $table->string('enlace')->nullable();
            $table->integer('idperiodo')->unsigned();
            $table->foreign('idperiodo')->references('id')->on('periocidades');
            $table->unsignedBigInteger('idnivelindex');
            $table->foreign('idnivelindex')->references('id')->on('niveles');
            $table->boolean('condicion')->default(1);
            $table->integer('sjr')->nullable(3);
            $table->integer('citescore')->nullable(3);
            $table->integer('articulo_numero')->nullable();
            $table->string('review')->nullable();
            $table->string('tiempo_respuesta')->nullable();
            $table->integer('referencias')->nullable(3);
            $table->string('citados')->nullable();
            $table->string('open_access')->nullable();
            $table->string('nivel_rechazo')->nullable();

            $table->timestamps();
        });
        DB::table('editoriales')->insert(array(
            'id'=>'1',
            'codigo'=>'R00000',
            'nombre'=>'Editorial no asignada',
            'descripcion'=>'Falta asignar editorial',
            'lineaInvestigacion'=>NULL,
            'idioma'=>NULL,
            'pais'=>NULL,
            'enlace'=>NULL,
            'idperiodo'=>2,
            'idnivelindex'=>4,
            'condicion'=>1,
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
        Schema::dropIfExists('editoriales');
    }
}
