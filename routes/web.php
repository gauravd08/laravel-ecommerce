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

Route::get('/', 'Frontend\PagesController@home');

Route::get('/user/createRoles', 'Auth\AuthController@createRoles');
Route::get('/user/createUsers', 'Auth\AuthController@createUsers');