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

Route::get('/', function () {
    return view('auth.login');
});

/* Registrar un usuario */
Route::get('/admin', function () {
    return view('auth.register');
});

Auth::routes([
    //'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', 'HomeController@index')->name('home');

/* Rutas para informacion laboral */
Route::post('/trabajo', 'TrabajoController@store');
Route::get('/trabajo/{id_estudiante}', 'TrabajoController@create');

