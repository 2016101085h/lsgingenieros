<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;

class ProfesorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $profesors = Profesor::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $profesors = Profesor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $profesors->total(),
                'current_page' => $profesors->currentPage(),
                'per_page'     => $profesors->perPage(),
                'last_page'    => $profesors->lastPage(),
                'from'         => $profesors->firstItem(),
                'to'           => $profesors->lastItem(),
            ],
            'profesors' => $profesors
        ];
    }

    public function selectProfesor(Request $request){
        // // if (!$request->ajax()) return redirect('/');
        $profesors = Profesor::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['profesors' => $profesors];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // // if (!$request->ajax()) return redirect('/');
        $profesor = new Profesor();
        $profesor->nombre = $request->nombre;
        $profesor->apellido = $request->apellido;
        $profesor->email = $request->email;
        $profesor->celular = $request->celular;
        $profesor->dni = $request->dni;
        $profesor->grado_academico = $request->grado_academico;
        $profesor->direccion = $request->direccion;
        $profesor->condicion = '1';
        $profesor->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->nombre = $request->nombre;
        $profesor->apellido = $request->apellido;
        $profesor->email = $request->email;
        $profesor->celular = $request->celular;
        $profesor->dni = $request->dni;
        $profesor->grado_academico = $request->grado_academico;
        $profesor->direccion = $request->direccion;
        $profesor->condicion = '1';
        $profesor->save();
    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->condicion = '0';
        $profesor->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $profesor = Profesor::findOrFail($request->id);
        $profesor->condicion = '1';
        $profesor->save();
    }
}
