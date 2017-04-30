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
Route::get('/admin', 'AdminController@index');

/**
 * Catalog routes
 */
Route::get('/admin/catalog', [
    'uses' => 'CatalogController@index',
    'as' => 'catalog.index'
]);

Route::post('/admin/catalog/action', [
    'uses' => 'CatalogController@massAction',
    'as' => 'catalog.massAction'
]);

/**
 * Product routes
 */
Route::get('/product/{id}/{title}', [
    'uses' => 'ProductController@show',
    'as' => 'product.show'
]);

Route::get('/admin/product/create', [
    'uses' => 'ProductController@create',
    'as' => 'product.create'
]);

Route::get('/admin/catalog/specifications', [
    'uses' => 'ProductController@createWithCategory',
    'as' => 'product.createWithCategory'
]);

Route::post('/admin/product/create/save', [
    'uses' => 'ProductController@store',
    'as' => 'product.store'
]);

Route::get('/admin/product/edit/{id}', [
    'uses' => 'ProductController@edit',
    'as' => 'product.edit'
]);

Route::post('/admin/product/update/{id}', [
    'uses' => 'ProductController@update',
    'as' => 'product.update'
]);

Route::post('/admin/product/delete/{id}', [
    'uses' => 'ProductController@delete',
    'as' => 'product.delete'
]);

/**
 * User routes
 */
Route::get('/user/login', 'Auth\LoginController@index');

Route::post('/user/logout', 'Auth\LoginController@logout');

Route::get('/user/register', 'Auth\RegisterController@index');

Route::get('/user/profile', [
	'uses' => 'UserController@index',
	'as' => 'user.index'
]);

/**
 * Cart routes
 */
Route::get('/cart', [
    'uses' => 'CartController@index',
    'as' => 'cart.index'
]);

Route::post('/cart/add/{id}', [
    'uses' => 'CartController@store',
    'as' => 'cart.store'
]);

Route::get('/cart/remove/{id}', [
    'uses' => 'CartController@delete',
    'as' => 'cart.delete'
]);

Route::post('/cart/update', [
   'uses' => 'CartController@update',
    'as' => 'cart.update'
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
