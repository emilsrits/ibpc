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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/roles/create', 'RolesController@role');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', [
    'uses' => 'ProductController@index',
    'as' => 'shop.index'
]);

Route::get('/profile', [
	'uses' => 'UserController@index',
	'as' => 'user.profile'
]);

Route::get('/addToCart/{id}', [
	'uses' => 'ProductController@addToCart',
	'as' => 'shop.addToCart'
]);

Route::get('/shop/cart', [
	'uses' => 'ProductController@cart',
	'as' => 'shop.cart'
]);

