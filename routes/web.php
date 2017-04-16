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

Route::get('/', [
    'uses' => 'ProductController@index',
    'as' => 'shop.index'
]);

Route::get('/home', 'HomeController@index');

Route::get('/roles/create', 'RolesController@role');

Route::get('/admin', 'AdminController@index');

Route::get('/user/login', 'Auth\LoginController@index');

Route::post('/user/logout', 'Auth\LoginController@logout');

Route::get('/user/register', 'Auth\RegisterController@index');

Route::get('/user/profile', [
	'uses' => 'UserController@profile',
	'as' => 'user.profile'
]);

Route::get('/cart/add/{id}', [
	'uses' => 'CartController@addToCart',
	'as' => 'cart.addToCart'
]);

Route::post('/cart/add/{id}', [
    'uses' => 'CartController@addToCart',
    'as' => 'cart.addToCart'
]);

Route::get('/cart/remove/{id}', [
    'uses' => 'CartController@removeFromCart',
    'as' => 'cart.removeFromCart'
]);

Route::get('/cart', [
	'uses' => 'CartController@index',
	'as' => 'cart.index'
]);

Route::get('/product/{id}', [
   'uses' => 'ProductController@viewProduct',
    'as' => 'product.viewProduct'
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
