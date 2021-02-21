<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
});

Route::get('departamentos', 'DepartamentoController@ListarDepartamento');
Route::get('marcas', 'MarcaController@ListarMarca');
Route::get('productosbycategoria/{id_dep}', 'ProductoController@ListarProductos');
Route::get('getdesProducto/{pro_nombre}/{dep_id}', 'ProductoController@GetDescripcionProducto');
Route::get('ubi_dep', 'UbicacionController@ListarUbidep');
Route::get('ubi_prov/{id}', 'UbicacionController@ListarUbiprov');
Route::get('ubi_dist/{id}', 'UbicacionController@ListarUbidist');
Route::resource('productos', 'ProductoController');
Route::resource('indexdep', 'DepartamentoController');
Route::resource('indexmar', 'MarcaController');


