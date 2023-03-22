<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/datosNotaria', [App\Http\Controllers\DataNotariaController::class, 'index'])->name('datosNotaria')->middleware('auth');

Route::get('/adminUsuarios', [App\Http\Controllers\AdminUsuariosController::class, 'index'])->name('adminUsuarios')->middleware('auth');

Route::post('/DatosNotaria/Consulta',[App\Http\Controllers\DataNotariaController::class, 'consultaVariables'])->name('DatosNotaria.consulta');
Route::post('/DatosNotaria/Actualizar',[App\Http\Controllers\DataNotariaController::class, 'actualizarVariable'])->name('DatosNotaria.actualizar');
Route::post('/DatosNotaria/cargarMunicipios',[App\Http\Controllers\DataNotariaController::class, 'cargarMunicipios'])->name('DatosNotaria.cargarMunicipios');
