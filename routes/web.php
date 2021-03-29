<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Controller@getWelcome')->name('welcome');

/* Rutas de Auth desativadas
Auth::routes();
*/

Route::get('/login','ConnectController@getLogin')->name('login');
Route::post('/login','ConnectController@postLogin')->name('login');
Route::get('/registerate','ConnectController@getRegister')->name('resgisterate');
Route::post('/registerate','ConnectController@postRegister')->name('resgisterate');
Route::get('/logout','ConnectController@getLogout')->name('logout');

//Rutas Paginas Web
Route::get('/quienes','QuienesController@getHome');
Route::get('/{id}/especialidades','Controller@getEspecialidad');
Route::get('/{id}/servicio','Controller@getServicio');
Route::get('/{id}/sede','Controller@getSede');
Route::get('/noticia','NoticiaController@getHome');
Route::get('/{id}/vnoticia','NoticiaController@getViewNoticia');
Route::get('/contacto','ContactoController@getContacto');
Route::post('/contacto','ContactoController@postContacto');

//receta
Route::get('/recetas','RecetaController@getRecetas')->name('recetas');
Route::post('/recetas','RecetaController@postRecetas')->name('recetas');
Route::get('/receta/{codigo}','RecetaController@getReceta')->name('receta');
