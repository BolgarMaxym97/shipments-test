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
    Route::post('/logout', 'Auth\AuthCustomController@logout')->name('logout');

    //Shipments
    Route::get('/', 'ShipmentController@index')->name('home');
    Route::get('/get-shipments', 'ShipmentController@getShipments')->name('get-shipments');
    Route::post('/send-shipment', 'ShipmentController@sendShipment')->name('send-shipment');
    Route::post('/remove-shipment', 'ShipmentController@removeShipment')->name('remove-shipment');
    Route::post('/create-shipment', 'ShipmentController@createShipment')->name('create-shipment');
    Route::post('/edit-shipment', 'ShipmentController@editShipment')->name('edit-shipment');

});

Route::get('/login', 'Auth\AuthCustomController@index')->name('login');
Route::post('/login-api', 'Auth\AuthCustomController@login')->name('login-api');


