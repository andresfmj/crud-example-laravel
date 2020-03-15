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

Route::get('/react/{route?}', function () {
    return view('react.index');
})->where('route', '[0-9A-Za-z.\/?]+');


Route::get('/', function() {
    return redirect('/home');
});

Auth::routes();

Route::group(['prefix' => 'home'], function () {
    
    Route::get('/', 'HomeController@index')->name('home');    

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UsersController@index')->name('users');
        Route::get('/create', 'UsersController@create');
        Route::post('/create', 'UsersController@store');
        Route::get('/{id}/edit', 'UsersController@edit');
        Route::post('/{id}/edit', 'UsersController@update');
        Route::post('/{id}/delete', 'UsersController@destroy');
    });

    Route::group(['prefix' => 'citas'], function () {
        Route::get('/', 'CitasController@index')->name('citas');
        Route::get('/create', 'CitasController@create');
        Route::post('/create', 'CitasController@store');
        Route::get('/{id}/edit', 'CitasController@edit');
        Route::post('/{id}/edit', 'CitasController@update');
        Route::post('/{id}/delete', 'CitasController@destroy');
    });

});

