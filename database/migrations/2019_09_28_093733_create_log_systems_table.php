<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_systems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('description');
            $table->string('ip');
            $table->string('agent');
            $table->integer('user_id');
            $table->string('user_email');
            $table->boolean('error');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_systems');
    }
}
