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

/**
 * Base routes
 */
Route::get('/', [
    'uses' => 'ProductController@index',
    'as' => 'shop.index'
]);

/**
 * User role routes
 */
Route::get('/roles/create', 'RolesController@role');

/**
 * Admin routes
 */
Route::get('/admin', 'AdminController@getAdmin');

Route::get('/admin/catalog', [
    'uses' => 'AdminController@getCatalog',
    'as' => 'admin.getCatalog'
]);

Route::get('/admin/products/create', [
    'uses' => 'AdminController@getCreateProduct',
    'as' => 'admin.getCreateProduct'
]);

Route::post('/admin/products/create/save', [
    'uses' => 'AdminController@postSaveProduct',
    'as' => 'admin.postSaveProduct'
]);

Route::get('/admin/products/edit/{id}', [
    'uses' => 'AdminController@getEditProduct',
    'as' => 'admin.getEditProduct'
]);

Route::get('/admin/catalog/specifications', [
    'uses' => 'AdminController@getProductSpecifications',
    'as' => 'admin.getProductSpecifications'
]);

/**
 * User routes
 */
Route::get('/user/login', 'Auth\LoginController@index');

Route::post('/user/logout', 'Auth\LoginController@logout');

Route::get('/user/register', 'Auth\RegisterController@index');

Route::get('/user/profile', [
	'uses' => 'UserController@getProfile',
	'as' => 'user.getProfile'
]);

/**
 * Cart routes
 */
Route::get('/cart', [
    'uses' => 'CartController@getCart',
    'as' => 'cart.getCart'
]);

Route::post('/cart/add/{id}', [
    'uses' => 'CartController@postAddToCart',
    'as' => 'cart.postAddToCart'
]);

Route::get('/cart/remove/{id}', [
    'uses' => 'CartController@getRemoveFromCart',
    'as' => 'cart.getRemoveFromCart'
]);

Route::post('/cart/update', [
   'uses' => 'CartController@postUpdateCart',
    'as' => 'cart.postUpdateCart'
]);

/**
 * Product routes
 */
Route::get('/product/{id}/{code}', [
   'uses' => 'ProductController@getProduct',
    'as' => 'product.getProduct'
]);

/**
 * Resource routes
 */
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
