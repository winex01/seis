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
Route::get('/', 'WelcomeController@all')->name('welcome.all');
Route::get('/year/{event}', 'WelcomeController@sports')->name('welcome.sports');
Route::get('/year/sports/{event}', 'WelcomeController@yearSports')->name('welcome.yearSports');
Route::get('/year/scheduleAndMatches/{game}', 'WelcomeController@scheduleAndMatches')->name('welcome.scheduleAndMatches');
Route::get('/year/scoreboard/{event}', 'WelcomeController@scoreboard')->name('welcome.scoreboard');
Route::get('/year/result/{game}', 'WelcomeController@overallSportsWinner');

// auth
Auth::routes();

// manager auth
Route::get('managerlogin', 'ManagerLoginController@showLoginForm')->name('managerLogin');
Route::post('managerlogin', 'ManagerLoginController@login')->name('managerLogin.submit');
Route::get('managerlogin/logout', 'ManagerLoginController@logout')->name('managerLogin.logout');

// manager template
Route::get('manager/home', 'ManagerHomeController@home')->name('managerHome.home');

// home
Route::get('/home', 'HomeController@index')->name('home');

// event
Route::get('event/eventstatus/{event}', 'EventController@eventStatus')->name('event.eventstatus');
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
Route::post('manager/match/winner/', 'MatchController@setWinner')->name('match.setWinner');
Route::get('manager/match/all/{game}', 'MatchController@all')->name('match.all');
Route::resource('manager/match', 'MatchController');

Route::post('manager/assignmedals/', 'AssignMedalsController')->name('assign.medals');

// sports manager
Route::get('manager/all', 'managerController@all')->name('manager.all');
Route::resource('manager', 'managerController');

//game
Route::get('game/matches/{game}', 'GameController@matches')->name('game.matches');
Route::post('game/assignManager', 'GameController@assignManager')->name('game.assignManager');

Route::resource('manager/sport', 'sportController');


