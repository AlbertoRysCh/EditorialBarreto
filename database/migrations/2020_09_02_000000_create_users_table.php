<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('email',50)->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('tipo_documento',250)->nullable();
            $table->string('num_documento',20)->nullable();
            $table->string('direccion',250)->nullable();
            $table->string('telefono',20)->nullable();
            $table->boolean('estado')->default(true);
            $table->boolean('condicion')->default(1);
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('zonas');
            $table->unsignedBigInteger('idrol');
            $table->foreign('idrol')->references('id')->on('roles');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->rememberToken();
    
            });
            DB::table('users')->insert([
                ['id' => '1',
                'nombre' => 'Admin',
                'email' => 'lreyes@innovascientific.com',
                'username' => 'admin',
                'password' => bcrypt('12345678*'),
                'tipo_documento' => 'DNI',
                'num_documento' => '12345678',
                'direccion' => 'Lima',
                'telefono' => '000000000',
                'zona_id' => 1,
                'idrol' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            ]);
            DB::table('users')->insert([
                ['id' => '2',
                'nombre' => 'AsesorVenta default',
                'email' => '0',
                'username' => 'aseso',
                'password' => bcrypt('12345678*'),
                'tipo_documento' => 'DNI',
                'num_documento' => '0',
                'direccion' => 'Lima',
                'telefono' => '000000000',
                'zona_id' => 1,
                'idrol' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            ]);
            DB::table('users')->insert([
                ['id' => '3',
                'nombre' => 'No asignado',
                'email' => '0',
                'username' => 'noasig',
                'password' => bcrypt('123456789*'),
                'tipo_documento' => 'DNI',
                'num_documento' => '0',
                'direccion' => 'Lima',
                'telefono' => '000000000',
                'zona_id' => 1,
                'idrol' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
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
        Schema::dropIfExists('users');
    }
}
