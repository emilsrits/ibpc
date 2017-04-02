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
	'as' => 'cart.addToCart'
]);

Route::get('/shop/cart', [
	'uses' => 'ProductController@cart',
	'as' => 'cart.index'
]);

Route::get('/storage/{filePath}', function ($filePath) {
    $path = storage_path('public/' . $filePath);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
