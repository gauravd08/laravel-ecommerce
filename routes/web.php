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

//admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function()
{
    //Pages
    Route::get('pages', 'Admin\PagesController@index')->name('pageSummary');
    Route::any('ajax-pages', 'Admin\PagesController@ajaxIndex');
    Route::any('pages/edit/{id}', 'Admin\PagesController@edit')->name('editPage');
});

//member routes
Route::group(['prefix' => 'member', 'middleware' => ['role:member']], function()
{
    
});