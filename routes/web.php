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
	
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'RecordsController@showLoggedWorkers');
Route::get('/setpassword', 'HomeController@openSetPasswordView');
Route::post('/setpassword', 'UsersController@updatePassword');


/*Shops*/
Route::get('/shops', 'ShopController@getShops');
Route::get('/shops/add', 'ShopController@openAddShopView');
Route::get('/shops/edit/{shop}', 'ShopController@openEditShopView');
Route::patch('/shops/edit/{shop}', 'ShopController@updateShop');
Route::delete('/shops/delete/{shop}', 'ShopController@deleteShop');
Route::post('/shops/add', 'ShopController@addShop');
/*Managers*/
Route::get('/managers', 'UsersController@managers');
Route::get('/managers/add', 'UsersController@openAddManagerView');
Route::get('/managers/edit/{user}', 'UsersController@openEditManagerView');
Route::patch('/managers/edit/{user}', 'UsersController@updateManager');
Route::delete('/managers/delete/{user}', 'UsersController@deleteManager');
Route::post('/managers/add', 'UsersController@addManager');
/*Workers*/
Route::get('/workers', 'UsersController@workers');
Route::get('/workers/add', 'UsersController@openAddWorkerView');
Route::get('/workers/edit/{user}', 'UsersController@openEditWorkerView');
Route::patch('/workers/edit/{user}', 'UsersController@updateWorker');
Route::delete('/workers/delete/{user}', 'UsersController@deleteWorker');
Route::post('/workers/add/{worker_id}', 'UsersController@addWorker');
Route::get('/workers/details/{user}', 'RecordsController@openWorkerDetailsView');
Route::patch('/workers/reset/{user}', 'UsersController@resetPassword');

/*Records*/
Route::post('/record/add', 'RecordsController@addStartRecord');
Route::patch('/record/finish', 'RecordsController@finishRecord');