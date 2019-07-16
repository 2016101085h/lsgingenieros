<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable=[
        'nombre','apellido','email','celular','dni','direccion','condicion'
    ];
    public function estudiante()
    {
        return $this->hasOne('App\Estudiante');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
    public function interesado()
    {
        return $this->hasOne('App\Interesado');
    }
}
