<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profesor_id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->integer('estudiante_id')->unsigned();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('profesor_id')->references('id')->on('profesors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}
