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
    Route::post('/create', 'UsersController@store');
});
