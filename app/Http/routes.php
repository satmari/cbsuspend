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

// Route::get('/', 'WelcomeController@index');
Route::get('home', 'boxTableController@index');

// Route::get('/', 'HomeController@index');
Route::get('/', 'boxTableController@index');

// Add
Route::get('add', 'boxAddController@index');
Route::post('searchinteos', 'boxAddController@searchinteos');
Route::post('sticker', 'boxAddController@sticker');
Route::post('setsticker', 'boxAddController@setsticker');
Route::post('set_sticker', 'boxAddController@set_sticker');
Route::post('set_palet', 'boxAddController@set_palet');
Route::post('set_coment', 'boxAddController@set_coment');
Route::get('addlist', 'boxAddController@addlist');

// Change Qty
Route::get('scanbox', 'boxAddController@scanbox');
Route::post('change_quantity', 'boxAddController@change_quantity');
Route::post('update_quantity/{id}', 'boxAddController@update_quantity');

// Change Palet
Route::get('scanbox_p', 'boxAddController@scanbox_p');
Route::post('change_palet', 'boxAddController@change_palet');
Route::post('update_palet/{id}', 'boxAddController@update_palet');

// Change Sticker
Route::get('scanbox_s', 'boxAddController@scanbox_s');
Route::post('change_sticker', 'boxAddController@change_sticker');
Route::post('update_sticker/{id}', 'boxAddController@update_sticker');

//Change coment
Route::get('edit_coment/{id}', 'boxTableController@edit_coment');
Route::post('update_coment/{id}', 'boxTableController@update_coment');

// Remove
Route::get('remove', 'boxRemoveController@index');
Route::post('removelist', 'boxRemoveController@removelist');
Route::post('remove', 'boxRemoveController@remove');

// Stickers table
Route::get('stickers', 'StickersController@index');
Route::get('add_new_sticker', 'StickersController@add_new_sticker');
Route::post('sticker_insert', 'StickersController@sticker_insert');
Route::get('sticker/{id}', 'StickersController@edit_sticker');
Route::post('sticker_update/{id}', 'StickersController@update');

// Palets table
Route::get('palets', 'PaletsController@index');
Route::get('add_new_palet', 'PaletsController@add_new_palet');
Route::post('palet_insert', 'PaletsController@palet_insert');
Route::get('palet/{id}', 'PaletsController@edit_palet');
Route::post('palet_update/{id}', 'PaletsController@update');
Route::get('add_palet_location', 'PaletsController@add_palet_location');
Route::post('add_palet_location', 'PaletsController@choose_location');
Route::post('update_location/{selected_palet}', 'PaletsController@update_location');

// Locations table
Route::get('locations', 'LocationsController@index');
Route::get('add_new_location', 'LocationsController@add_new_location');
Route::post('location_insert', 'LocationsController@location_insert');
Route::get('location/{id}', 'LocationsController@edit_location');
Route::post('location_update/{id}', 'LocationsController@update');

// Table
Route::get('table', 'boxTableController@index');
Route::get('table_log', 'boxTableController@index_log');
Route::get('export', 'boxTableController@export');

// Compare function
Route::get('compare', 'compareController@index');
Route::get('compare_p', 'compareController@index_p');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
