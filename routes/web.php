<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido/contenido');
});
Route::get('/estudiante', 'EstudianteController@index');
Route::post('/estudiante/registrar', 'EstudianteController@store');
Route::put('/estudiante/actualizar', 'EstudianteController@update');
Route::put('/estudiante/desactivar', 'EstudianteController@desactivar');
Route::put('/estudiante/activar', 'EstudianteController@activar');
Route::get('/estudiante/selectestudiante', 'EstudianteController@selectEstudiante');

Route::get('/curso', 'CursoController@index');
Route::post('/curso/registrar', 'CursoController@store');
Route::put('/curso/actualizar', 'CursoController@update');
Route::put('/curso/desactivar', 'CursoController@desactivar');
Route::put('/curso/activar', 'CursoController@activar');
Route::get('/curso/selectcurso', 'CursoController@selectCurso');

Route::get('/profesor', 'ProfesorController@index');
Route::post('/profesor/registrar', 'ProfesorController@store');
Route::put('/profesor/actualizar', 'ProfesorController@update');
Route::put('/profesor/desactivar', 'ProfesorController@desactivar');
Route::put('/profesor/activar', 'ProfesorController@activar');
Route::get('/profesor/selectprofesor', 'ProfesorController@selectProfesor');