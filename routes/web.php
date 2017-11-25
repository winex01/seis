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

// guest
Route::get('/', function () {
    return view('welcome');
});

// auth
Auth::routes();

// home
Route::get('/home', 'HomeController@index')->name('home');

// event
Route::get('event/all', 'EventController@all');
Route::resource('event', 'EventController');
