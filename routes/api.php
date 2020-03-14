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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('api')->prefix('/users')->group(function() {

    Route::post('auth', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->middleware('auth');

    Route::get('/', 'UsersController@index');
    Route::get('/{id}', 'UsersController@show');
    Route::post('/store', 'UsersController@store');
    Route::patch('/{id}/update', 'UsersController@update');
    Route::delete('/{id}/delete', 'UsersController@destroy');
});


Route::middleware('api')->prefix('/citas')->group(function() {

    Route::get('/', 'CitasController@index');
    Route::get('/{id}', 'CitasController@show');
    Route::post('/store', 'CitasController@store');
    Route::patch('/{id}/update', 'CitasController@update');
    Route::delete('/{id}/delete', 'CitasController@destroy');
});
