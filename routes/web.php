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
 * Category routes
 */
Route::get('/admin/categories', [
    'uses' => 'CategoryController@index',
    'as' => 'category.index'
]);

Route::post('/admin/categories/action', [
    'uses' => 'CategoryController@massAction',
    'as' => 'category.massAction'
]);

Route::get('/admin/category/create', [
    'uses' => 'CategoryController@create',
    'as' => 'category.create'
]);

Route::post('/admin/category/create/save', [
    'uses' => 'CategoryController@store',
    'as' => 'category.store'
]);

Route::get('/admin/category/edit/{id}', [
    'uses' => 'CategoryController@edit',
    'as' => 'category.edit'
]);

Route::post('/admin/category/update/{id}', [
    'uses' => 'CategoryController@update',
    'as' => 'category.update'
]);

Route::post('/admin/category/delete/{id}', [
    'uses' => 'CategoryController@delete',
    'as' => 'category.delete'
]);

/**
 * Specification / Attribute Group routes
 */
Route::get('/admin/specifications', [
    'uses' => 'SpecificationController@index',
    'as' => 'specification.index'
]);

Route::post('/admin/specifications/action', [
    'uses' => 'SpecificationController@massAction',
    'as' => 'specification.massAction'
]);

Route::get('/admin/specification/create', [
    'uses' => 'SpecificationController@create',
    'as' => 'specification.create'
]);

Route::post('/admin/specification/create/save', [
    'uses' => 'SpecificationController@store',
    'as' => 'specification.store'
]);

Route::get('/admin/specification/edit/{id}', [
    'uses' => 'SpecificationController@edit',
    'as' => 'specification.edit'
]);

Route::post('/admin/specification/update/{id}', [
    'uses' => 'SpecificationController@update',
    'as' => 'specification.update'
]);

Route::post('/admin/specification/delete/{id}', [
    'uses' => 'SpecificationController@delete',
    'as' => 'specification.delete'
]);

/**
 * Attribute routes
 */
Route::post('/admin/attributes/action', [
    'uses' => 'AttributeController@massAction',
    'as' => 'attribute.massAction'
]);

Route::get('/admin/attribute/create/{specificationId}', [
    'uses' => 'AttributeController@create',
    'as' => 'attribute.create'
]);

Route::post('/admin/attribute/create/save/{specificationId}', [
    'uses' => 'AttributeController@store',
    'as' => 'attribute.store'
]);

Route::get('/admin/attribute/edit/{specificationId}/{id}', [
    'uses' => 'AttributeController@edit',
    'as' => 'attribute.edit'
]);

Route::post('/admin/attribute/update/{specificationId}/{id}', [
    'uses' => 'AttributeController@update',
    'as' => 'attribute.update'
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
