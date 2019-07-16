<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteresadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interesados', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('curso_id')->unsigned();
            $table->string('grado_academico',50);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interesados');
    }
}
