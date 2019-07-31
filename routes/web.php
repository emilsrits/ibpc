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
Route::get('/c/{parent}/{child}', [
    'uses' => 'StoreController@categorize',
    'as' => 'store.categorize'
]);
Route::get('/p/{code}', [
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
        'uses' => 'ProductController@createAsync',
        'as' => 'product.createWithCategory'
    ]);
    Route::post('/product/create/save', [
        'uses' => 'ProductController@store',
        'as' => 'product.store'
    ]);
    Route::get('/product/edit/{product}', [
        'uses' => 'ProductController@edit',
        'as' => 'product.edit'
    ]);
    Route::post('/product/update', [
        'uses' => 'ProductController@updateAsync',
        'as' => 'product.updateWithAjax'
    ]);
    Route::post('/product/update/{product}', [
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
    Route::get('/category/edit/{category}', [
        'uses' => 'CategoryController@edit',
        'as' => 'category.edit'
    ]);
    Route::post('/category/update/{category}', [
        'uses' => 'CategoryController@update',
        'as' => 'category.update'
    ]);

    /**
     * Specification / Property Group routes
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
    Route::get('/specification/edit/{specification}', [
        'uses' => 'SpecificationController@edit',
        'as' => 'specification.edit'
    ]);
    Route::post('/specification/update/{specification}', [
        'uses' => 'SpecificationController@update',
        'as' => 'specification.update'
    ]);

    /**
     * Property routes
     */
    Route::post('/properties', [
        'uses' => 'PropertyController@action',
        'as' => 'property.action'
    ]);
    Route::get('/property/create/{specification}', [
        'uses' => 'PropertyController@create',
        'as' => 'property.create'
    ]);
    Route::post('/property/create/save/{specification}', [
        'uses' => 'PropertyController@store',
        'as' => 'property.store'
    ]);
    Route::get('/property/edit/{property}', [
        'uses' => 'PropertyController@edit',
        'as' => 'property.edit'
    ]);
    Route::post('/property/update/{property}', [
        'uses' => 'PropertyController@update',
        'as' => 'property.update'
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
    Route::get('/user/edit/{user}', [
        'uses' => 'UserController@edit',
        'as' => 'user.edit'
    ]);
    Route::post('/user/update/{user}', [
        'uses' => 'UserController@update',
        'as' => 'user.update'
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
    Route::get('/order/edit/{order}', [
        'uses' => 'OrderController@edit',
        'as' => 'order.edit'
    ]);
    Route::post('/order/update/{order}', [
        'uses' => 'OrderController@update',
        'as' => 'order.update'
    ]);
});

/**
 * User routes
 */
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    /**
     * User account routes
     */
Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => ['auth', 'active']], function () {
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
        Route::post('/update/{user}', [
            'uses' => 'AccountController@update',
            'as' => 'account.update'
        ])->middleware('owner');
    });
});

/**
 * Cart routes
 */
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [
        'uses' => 'CartController@index',
        'as' => 'cart.index'
    ]);
    Route::post('/add/{product}', [
        'uses' => 'CartController@store',
        'as' => 'cart.store'
    ]);
    Route::post('/add', [
        'uses' => 'CartController@storeAsync',
        'as' => 'cart.storeWithAjax'
    ]);
    Route::post('/remove', [
        'uses' => 'CartController@deleteAsync',
        'as' => 'cart.delete'
    ]);
    Route::post('/update', [
       'uses' => 'CartController@update',
        'as' => 'cart.update'
    ]);
});

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
