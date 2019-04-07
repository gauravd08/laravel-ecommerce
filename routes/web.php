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
    
});

//member routes
Route::group(['prefix' => 'member', 'middleware' => ['role:member']], function()
{
    
});