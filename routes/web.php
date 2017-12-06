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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Backstage'], function () {
    Route::get('/posts', 'PostController@index');
    Route::get('/get_posts', 'PostController@getPosts');
    Route::post('/post_add', 'PostController@add');

    Route::get('/users', 'UserController@index');
    Route::post('/user_add', 'UserController@add');
    Route::post('/reset_password', 'UserController@resetPassword');
    Route::get('/getEmplyee', 'UserController@getEmplyee');
    Route::get('/get_permission', 'UserController@getPermission');

    Route::post('/transport_add', 'TransportController@add');
    Route::get('/transport_list', 'TransportController@getLists');
    Route::get('/transport_get', 'TransportController@get');
    Route::post('/transport_pay', 'TransportController@payment');
});
