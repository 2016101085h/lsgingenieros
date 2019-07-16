<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('id')->unsigned();
            $table->integer('rol_id')->unsigned();
            $table->string('usuario',50);
            $table->string('password',50);
            $table->timestamps();
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('cascade')->onUpdate('cascade');
        });
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
