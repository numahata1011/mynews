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


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

//news関係_START
Route::get('news/create', 'Admin\NewsController@add');
Route::post('news/create', 'Admin\NewsController@create');//追記

Route::get('news', 'Admin\NewsController@index');// 追記(15)

Route::get('news/edit', 'Admin\NewsController@edit'); // 追記(16)
Route::post('news/edit', 'Admin\NewsController@update'); // 追記(16)
Route::get('news/delete', 'Admin\NewsController@delete');// 追記(16)
//news関係_END

//profile関係_START
Route::get('profile/create','Admin\ProfileController@add');
Route::post('profile/create', 'Admin\ProfileController@create');//課題追記

Route::get('profile', 'Admin\ProfileController@index');// 追記(16’)

Route::get('profile/edit','Admin\ProfileController@edit');
Route::post('profile/edit','Admin\ProfileController@update');//課題追記
Route::get('profile/delete', 'Admin\ProfileController@delete');// 追記(16’)
//profile関係_END

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'NewsController@index');

Route::get('profile', 'ProfileController@index');