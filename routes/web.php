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

Route::group(['middleware' => ['auth.custom']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/logout', 'Auth\AuthCustomController@logout')->name('logout');

});

Route::get('/login', 'Auth\AuthCustomController@index')->name('login');
Route::post('/login-api', 'Auth\AuthCustomController@login')->name('login-api');


