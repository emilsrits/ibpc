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
Route::get('/roles/create', 'RoleController@role');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index');

    /**
     * Catalog routes
     */
    Route::get('/catalog', [
        'uses' => 'CatalogController@index',
        'as' => 'catalog.index'
    ]);
    Route::post('/catalog/action', [
        'uses' => 'CatalogController@massAction',
        'as' => 'catalog.massAction'
    ]);

    /**
     * Product routes
     */
    Route::get('/product/create', [
        'uses' => 'ProductController@create',
        'as' => 'product.create'
    ]);
    Route::get('/product/categories', [
        'uses' => 'ProductController@createWithCategory',
        'as' => 'product.createWithCategory'
    ]);
    Route::post('/product/create/save', [
        'uses' => 'ProductController@store',
        'as' => 'product.store'
    ]);
    Route::get('/product/edit/{id}', [
        'uses' => 'ProductController@edit',
        'as' => 'product.edit'
    ]);
    Route::post('/product/update/{id}', [
        'uses' => 'ProductController@update',
        'as' => 'product.update'
    ]);
    Route::post('/product/delete/{id}', [
        'uses' => 'ProductController@delete',
        'as' => 'product.delete'
    ]);

    /**
     * Category routes
     */
    Route::get('/categories', [
        'uses' => 'CategoryController@index',
        'as' => 'category.index'
    ]);
    Route::post('/categories/action', [
        'uses' => 'CategoryController@massAction',
        'as' => 'category.massAction'
    ]);
    Route::get('/category/create', [
        'uses' => 'CategoryController@create',
        'as' => 'category.create'
    ]);
    Route::post('/category/create/save', [
        'uses' => 'CategoryController@store',
        'as' => 'category.store'
    ]);
    Route::get('/category/edit/{id}', [
        'uses' => 'CategoryController@edit',
        'as' => 'category.edit'
    ]);
    Route::post('/category/update/{id}', [
        'uses' => 'CategoryController@update',
        'as' => 'category.update'
    ]);
    Route::post('/category/delete/{id}', [
        'uses' => 'CategoryController@delete',
        'as' => 'category.delete'
    ]);

    /**
     * Specification / Attribute Group routes
     */
    Route::get('/specifications', [
        'uses' => 'SpecificationController@index',
        'as' => 'specification.index'
    ]);
    Route::post('/specifications/action', [
        'uses' => 'SpecificationController@massAction',
        'as' => 'specification.massAction'
    ]);
    Route::get('/specification/create', [
        'uses' => 'SpecificationController@create',
        'as' => 'specification.create'
    ]);
    Route::post('/specification/create/save', [
        'uses' => 'SpecificationController@store',
        'as' => 'specification.store'
    ]);
    Route::get('/specification/edit/{id}', [
        'uses' => 'SpecificationController@edit',
        'as' => 'specification.edit'
    ]);
    Route::post('/specification/update/{id}', [
        'uses' => 'SpecificationController@update',
        'as' => 'specification.update'
    ]);
    Route::post('/specification/delete/{id}', [
        'uses' => 'SpecificationController@delete',
        'as' => 'specification.delete'
    ]);

    /**
     * Attribute routes
     */
    Route::post('/attributes/action', [
        'uses' => 'AttributeController@massAction',
        'as' => 'attribute.massAction'
    ]);
    Route::get('/attribute/create/{specificationId}', [
        'uses' => 'AttributeController@create',
        'as' => 'attribute.create'
    ]);
    Route::post('/attribute/create/save/{specificationId}', [
        'uses' => 'AttributeController@store',
        'as' => 'attribute.store'
    ]);
    Route::get('/attribute/edit/{specificationId}/{id}', [
        'uses' => 'AttributeController@edit',
        'as' => 'attribute.edit'
    ]);
    Route::post('/attribute/update/{specificationId}/{id}', [
        'uses' => 'AttributeController@update',
        'as' => 'attribute.update'
    ]);

    /**
     * User routes
     */
    Route::get('/users', [
        'uses' => 'UserController@index',
        'as' => 'user.index'
    ]);
    Route::post('/users/action', [
        'uses' => 'UserController@massAction',
        'as' => 'user.massAction'
    ]);
    Route::get('/user/edit/{id}', [
        'uses' => 'UserController@edit',
        'as' => 'user.edit'
    ]);
    Route::post('/user/update/{id}', [
        'uses' => 'UserController@update',
        'as' => 'user.update'
    ]);

    /**
     * Role routes
     */
    Route::get('/roles', [
        'uses' => 'RoleController@index',
        'as' => 'role.index'
    ]);
});

/**
 * Product routes
 */
Route::get('/product/{id}/{title}', [
    'uses' => 'ProductController@show',
    'as' => 'product.show'
]);

/**
 * User routes
 */
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/user/login', [
        'uses' => 'LoginController@index',
        'as' => 'user.login'
    ]);

    Route::post('/user/logout', 'LoginController@logout');

    Route::get('/user/register', 'RegisterController@index');
});
Route::get('/user/profile', [
	'uses' => 'UserController@show',
	'as' => 'user.show'
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
 * Checkout routes
 */
Route::group(['prefix' => 'checkout', 'middleware' => ['auth', 'cart']], function () {
    Route::get('/', [
        'uses' => 'CheckoutController@index',
        'as' => 'checkout.index'
    ]);
    Route::get('/delivery', [
        'uses' => 'CheckoutController@getDelivery',
        'as' => 'checkout.getDelivery'
    ]);
    Route::get('/confirmation', [
        'uses' => 'CheckoutController@show',
        'as' => 'checkout.show'
    ]);
    Route::post('/confirmation', [
        'uses' => 'CheckoutController@show',
        'as' => 'checkout.show'
    ]);
    Route::get('/success', function () {
        return redirect()->back();
    });
    Route::post('/confirm', [
        'uses' => 'OrderController@store',
        'as' => 'order.store'
    ]);
});

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
