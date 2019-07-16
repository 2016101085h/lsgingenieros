<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $fillable=[
        'nombre','apellido','email','celular','dni','grado_academico','direccion','condicion'
    ];
   
    public function cursos(){
        return $this->hasMany('App\Curso');
    }
}
