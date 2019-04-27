<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/user/createRoles', 'Auth\AuthController@createRoles');
// Route::get('/user/createUsers', 'Auth\AuthController@createUsers');

//Public routes goes here...
Route::get('/', 'Frontend\PagesController@home');
Route::get('admin', 'Auth\AuthController@login');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

Route::get('member', 'Auth\AuthController@memberLogin');

//Login with google
Route::get('login/google', 'Auth\SocialAuthController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\SocialAuthController@handleGoogleCallback');

//Login with facebook
Route::get('login/facebook', 'Auth\SocialAuthController@redirectToFacebook');
Route::get('login/facebook/callback', 'Auth\SocialAuthController@handleFacebookCallback');

//admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function()
{
    //Pages
    Route::get('pages', 'Admin\PagesController@index')->name('pageSummary');
    Route::any('ajax-pages', 'Admin\PagesController@ajaxIndex');
    Route::any('pages/edit/{id}', 'Admin\PagesController@edit')->name('editPage');

    //Graphics
    Route::get('graphics', 'Admin\GraphicsController@index')->name('graphicSummary');
    Route::any('ajax-graphics', 'Admin\GraphicsController@ajaxIndex');
    Route::any('graphics/add', 'Admin\GraphicsController@add')->name('addGraphic');
    Route::any('graphics/edit/{id}', 'Admin\GraphicsController@edit')->name('editGraphic');
    Route::any('graphics/delete/{id}', 'Admin\GraphicsController@delete');
    Route::any('graphics/toggle/status/{model}/{status}', 'Admin\GraphicsController@toggleStatus');

    //categories
    Route::get('categories', 'Admin\CategoriesController@index')->name('categoriesSummary');
    Route::any('ajax-categories', 'Admin\CategoriesController@ajaxIndex');
    Route::any('category/add', 'Admin\CategoriesController@add')->name('addCategory');
    Route::any('category/edit/{id}', 'Admin\CategoriesController@edit')->name('editCategory');
    Route::any('category/delete/{id}', 'Admin\CategoriesController@delete');
    Route::any('category/toggle/status/{model}/{status}', 'Admin\CategoriesController@toggleStatus');

    //Brands
    Route::get('brands', 'Admin\BrandsController@index')->name('brandsSummary');
    Route::any('ajax-brands', 'Admin\BrandsController@ajaxIndex');
    Route::any('brand/add', 'Admin\BrandsController@add')->name('addBrand');
    Route::any('brand/edit/{id}', 'Admin\BrandsController@edit')->name('editBrand');
    Route::any('brand/delete/{id}', 'Admin\BrandsController@delete');
    Route::any('brand/toggle/status/{model}/{status}', 'Admin\BrandsController@toggleStatus');

    //Products
    Route::get('products', 'Admin\ProductsController@index')->name('productsSummary');
    Route::any('ajax-products', 'Admin\ProductsController@ajaxIndex');
    Route::any('product/add', 'Admin\ProductsController@add')->name('addproduct');
    Route::any('product/edit/{id}', 'Admin\ProductsController@edit')->name('editproduct');
    Route::any('product/delete/{id}', 'Admin\ProductsController@delete');
    Route::any('product/toggle/status/{model}/{status}', 'Admin\ProductsController@toggleStatus');
    
});

//member routes
Route::group(['prefix' => 'member', 'middleware' => ['role:member']], function()
{
    
});

Route::get('/{slug}', 'Frontend\PagesController@page');
Route::get('/product/{slug}', 'Frontend\PagesController@product');