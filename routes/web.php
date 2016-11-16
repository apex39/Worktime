<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
	
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/managers', 'UsersController@managers');
Route::get('/managers/add', 'UsersController@openAddManagerView');
Route::get('/managers/edit/{user}', 'UsersController@openEditManagerView');
Route::patch('/managers/edit/{user}', 'UsersController@updateManager');
Route::any('/managers/delete/{user}', 'UsersController@deleteManager');

Route::post('/managers/add', 'UsersController@addManager');