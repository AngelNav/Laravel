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

Route::get('/main', function () {
    return view('contenido/contenido');
})->name('main');

Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

Route::get('/articulo', 'ArticuloController@index');
Route::post('/articulo/registrar', 'ArticuloController@store');
Route::put('/articulo/actualizar', 'ArticuloController@update');
Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
Route::put('/articulo/activar', 'ArticuloController@activar');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/client', 'ClientController@index');
Route::post('/client/store', 'ClientController@store');
Route::put('/client/update', 'ClientController@update');

Route::get('/supplier', 'SupplierController@index');
Route::post('/supplier/store', 'SupplierController@store');
Route::put('/supplier/update', 'SupplierController@update');

Route::get('/rol', 'RolController@index');
Route::get('/rol/selectRol', 'RolController@selectRol');

Route::get('/user', 'UserController@index');
Route::post('/user/store', 'UserController@store');
Route::put('/user/update', 'UserController@update');
Route::put('/user/deactivate', 'UserController@deactivate');
Route::put('/user/activate', 'UserController@activate');

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
