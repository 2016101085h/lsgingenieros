<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable=[
        'nombre','horas_academicas','tipo','condicion'
    ];

    public function estudiante(){
        return $this->belongsTo('App\Estudiante');
    }
    public function profesor(){
        return $this->belongsTo('App\Profesor');
    }
    // $table->increments('id');
    // $table->string('nombre');
    // $table->integer('horas_academicas');
    // $table->boolean('condicion')->default(1);
    // $table->timestamps();
}
