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
Route::DELETE('event/game/{game}', 'EventController@destroyGame')->name('event.destroy.game');
Route::resource('event', 'EventController');

// game types
Route::get('gametype/all', 'GameTypeController@all')->name('gametype.all');
Route::resource('gametype', 'GameTypeController');

// teams
Route::get('team/all', 'TeamController@all')->name('team.all');
Route::resource('team', 'TeamController');

// users
// Route::get('user/all', 'UserController@all')->name('user.all');
// Route::resource('user', 'UserController');

// matches
Route::get('event/{event}/matches', 'MatchesController@index')->name('matches.index');

// sports manager
Route::get('sportsmanager/all', 'SportsManagerController@all')->name('sportsmanager.all');
Route::resource('sportsmanager', 'SportsManagerController');




