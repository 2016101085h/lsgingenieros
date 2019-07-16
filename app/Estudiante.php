<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Estudiante extends Model
{
    protected $fillable = [
        'id','grado_academico','condicion'
    ];
    public function persona(){
        return $this->belongsTo('App\Persona');
    }
    public function cursos(){
        return $this->hasMany('App\Curso');
    }
    // public function provedor()
    // {
    //     return $this->hasOne('App\Proveedor');
    // }

    // public function user()
    // {
    //     return $this->hasOne('App\User');
    // }
}
