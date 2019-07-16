<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Persona;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = Estudiante::join('personas','estudiantes.id','=','personas.id')
            ->select('personas.id','personas.nombre','personas.apellido',
            'personas.email','personas.direccion','personas.celular',
            'personas.dni','estudiantes.grado_academico',
            'estudiantes.condicion')
            ->orderBy('personas.id', 'desc')->paginate(3);
        }
        else{
            $personas = Estudiante::join('personas','estudiantes.id','=','personas.id')
            ->select('personas.id','personas.nombre','personas.apellido',
            'personas.email','personas.direccion','personas.celular',
            'personas.dni','estudiantes.grado_academico',
            'estudiantes.condicion')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->email = $request->email;
            $persona->dni = $request->dni;
            $persona->celular = $request->celular;
            $persona->direccion = $request->direccion;
           
            $persona->save();

            $estudiante = new Estudiante();
            $estudiante->grado_academico = $request->grado_academico;
           
            $estudiante->condicion = '1';
            $estudiante->id = $persona->id;
            $estudiante->save();

            $estudiante->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

        
        
    }

    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $estudiante = Estudiante::findOrFail($request->id);

            $persona = Persona::findOrFail($estudiante->id);

            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->email = $request->email;
            $persona->dni = $request->dni;
            $persona->celular = $request->celular;
           
            $persona->save();

            
            $estudiante->grado_academico = $request->grado_academico;           
            $estudiante->save();


            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->condicion = '0';
        $estudiante->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->condicion = '1';
        $estudiante->save();
    }


}
