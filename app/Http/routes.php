<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('test', [
    'as' => 'test',
    'uses' => 'TracerController@index'
]);

Route::get('t', function()
{
//    $resource = \App\Mahasiswa::with('kelamin', 'predikat', 'jurusan')
//        ->where('stakl', 'L')
//        ->paginate(10);
//
//    return $resource;

    return response()->json(['tes' => 'dafdsa']);
});
