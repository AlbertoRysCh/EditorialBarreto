<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('areas')->insert(array('id'=>'1','codigo'=>'A0001','nombre'=>'Ciencias Sociales','descripcion'=>'antropología, psicología, derecho, sociología, política, comunicación y educación','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'2','codigo'=>'A0002','nombre'=>'Ciencias Empresariales','descripcion'=>'administración, economía, finanzas, marketing y negocios internacionales','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'3','codigo'=>'A0003','nombre'=>'Ambiental','descripcion'=>'ciencias forestales, medio ambiente','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'4','codigo'=>'A0004','nombre'=>'Ciencia y tecnologías','descripcion'=>'ingenierías: industrial, telecomunicaciones, sistemas, informática, computación','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'5','codigo'=>'A0005','nombre'=>'Ciencias de la salud','descripcion'=>'Medicina, biomedicina, salud pública, salud mental, enfermería','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'6','codigo'=>'A0006','nombre'=>'No asignado','descripcion'=>'Falta por asignar el área de investigación','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'7','codigo'=>'A0007','nombre'=>'Ciencias Agronómicas','descripcion'=>'Seguridad alimentaria, sistemas agrícolas, desarrollo rural sostenible','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
        DB::table('areas')->insert(array('id'=>'8','codigo'=>'A0008','nombre'=>'Ciencias Militares','descripcion'=>'Defensa nacional, soberanía','condicion'=>1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
