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
 * Store routes
 */
Route::get('/', [
    'uses' => 'StoreController@index',
    'as' => 'store.index'
]);
Route::get('/search', [
    'uses' => 'StoreController@search',
    'as' => 'store.search'
]);
Route::get('/store/{parent}/{child}', [
    'uses' => 'StoreController@categorize',
    'as' => 'store.categorize'
]);
Route::get('/store/{code}', [
    'uses' => 'StoreController@show',
    'as' => 'store.show'
]);

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin', 'active']], function () {
    Route::get('/', 'AdminController@index');
    /**
     * Product routes
     */
    Route::get('/catalog', [
        'uses' => 'ProductController@index',
        'as' => 'product.index'
    ]);
    Route::post('/catalog', [
        'uses' => 'ProductController@action',
        'as' => 'product.action'
    ]);
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

    /**
     * Category routes
     */
    Route::get('/categories', [
        'uses' => 'CategoryController@index',
        'as' => 'category.index'
    ]);
    Route::post('/categories', [
        'uses' => 'CategoryController@action',
        'as' => 'category.action'
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

    /**
     * Specification / Attribute Group routes
     */
    Route::get('/specifications', [
        'uses' => 'SpecificationController@index',
        'as' => 'specification.index'
    ]);
    Route::post('/specifications', [
        'uses' => 'SpecificationController@action',
        'as' => 'specification.action'
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

    /**
     * Attribute routes
     */
    Route::post('/attributes', [
        'uses' => 'AttributeController@action',
        'as' => 'attribute.action'
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
    Route::post('/users', [
        'uses' => 'UserController@action',
        'as' => 'user.action'
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

    /**
     * Order routes
     */
    Route::get('/orders', [
        'uses' => 'OrderController@index',
        'as' => 'order.index'
    ]);
    Route::post('/orders', [
        'uses' => 'OrderController@action',
        'as' => 'order.action'
    ]);
    Route::get('/order/edit/{id}', [
        'uses' => 'OrderController@edit',
        'as' => 'order.edit'
    ]);
    Route::post('/order/update/{id}', [
        'uses' => 'OrderController@update',
        'as' => 'order.update'
    ]);
});

/**
 * User routes
 */
Route::group(['prefix' => 'user'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/login', [
            'uses' => 'LoginController@index',
            'as' => 'user.login'
        ]);
        Route::post('/logout', 'LoginController@logout');
        Route::get('/register', 'RegisterController@index');
    });

    /**
     * User account routes
     */
    Route::group(['middleware' => ['auth', 'active', 'owner']], function () {
        Route::get('/account', [
            'uses' => 'AccountController@index',
            'as' => 'account.index'
        ]);
        Route::get('/order/{id}', [
            'uses' => 'AccountController@showOrder',
            'as' => 'account.showOrder'
        ]);
        Route::get('/history', [
            'uses' => 'AccountController@showHistory',
            'as' => 'account.showHistory'
        ]);
        Route::get('/edit', [
            'uses' => 'AccountController@edit',
            'as' => 'account.edit'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'AccountController@update',
            'as' => 'account.update'
        ]);
    });
});

/**
 * Cart routes
 */
Route::get('/cart', [
    'uses' => 'CartController@index',
    'as' => 'cart.index'
]);
Route::post('/cart/add', [
    'uses' => 'CartController@storeWithAjax',
    'as' => 'cart.storeWithAjax'
]);
Route::post('/cart/add/{id}', [
    'uses' => 'CartController@store',
    'as' => 'cart.store'
]);
Route::post('/cart/remove', [
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
Route::group(['prefix' => 'checkout', 'middleware' => ['auth', 'active']], function () {
    Route::get('/success', [
        'uses' => 'OrderController@success',
        'as' => 'order.success'
    ]);
    Route::group(['middleware' => ['cart']], function () {
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
        Route::post('/confirm', [
            'uses' => 'OrderController@store',
            'as' => 'order.store'
        ]);
    });
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
