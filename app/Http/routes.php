<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', 'PostController@index');

Route::auth();

Route::get('/home', 'PostController@index');
Route::get('/post', 'PostController@index');
Route::get('post/show/{slug}', ['as' => 'post', 'uses' => 'PostController@show'])->where('slug', '[A-Za-z0-9-_]+');

Route::group(['middleware' => 'author'], function() {
    Route::get('post/add', 'PostController@add');
    Route::post('post/store', 'PostController@store');
    Route::get('post/edit/{slug}', 'PostController@edit');
    Route::post('post/update', 'PostController@update');
    Route::get('post/list', 'PostController@manage');
    Route::get('post/disable/{id}', 'PostController@disable');
    Route::get('post/active/{id}', 'PostController@active');

    Route::get('comment/list', 'CommentController@manage');
    Route::get('comment/disable/{id}', 'CommentController@disable');
    Route::get('comment/active/{id}', 'CommentController@active');
    Route::get('comment/delete/{id}', 'CommentController@delete');
});

Route::group(['middleware' => ['admin']], function() {
    Route::get('post/delete/{id}', 'PostController@delete');
    Route::get('user', 'UserController@manage');
    Route::get('user/edit/{id}', 'UserController@edit');
    Route::post('user/update', 'UserController@update');
});

Route::group(['middleware' => ['auth']], function() {
    Route::post('comment/add', 'CommentController@store');
});

Route::resource('demo', 'DemoController');