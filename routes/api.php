<?php

use Illuminate\Http\Request;

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

Route::post('/login', 'ApiController@loginUser');
Route::post('/shops', 'ApiController@sendAllShops');
Route::post('/managershops', 'ApiController@sendManagerShops');
Route::post('/records', 'ApiController@sendUserRecords');
Route::post('/activateuser', 'ApiController@activateUser');
