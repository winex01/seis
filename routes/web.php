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
Route::post('event/{event}/store/gametype', 'EventController@storeGameType')->name('event.store.gametype');
Route::get('event/{event}/gameTypes', 'EventController@gameTypes')->name('event.gameTypes');
Route::get('event/{event}/games', 'EventController@games')->name('event.games');
Route::get('event/all', 'EventController@all')->name('event.all');
Route::resource('event', 'EventController');

// game types
Route::get('gametype/all', 'GameTypeController@all')->name('gametype.all');
Route::resource('gametype', 'GameTypeController');

// events game
