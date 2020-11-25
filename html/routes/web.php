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
})->name('home');

Auth::routes();
Route::get('/users/profile', 'UsersController@profile')->name('profile');
Route::get('/users/dashboard', 'UsersController@dashboard')->name('dashboard');
Route::get('/users/animes/{status}', 'UsersController@retrieveAnimesUserWithStatus')->name('user.animes.status');
Route::post('/users/stats', 'AnimeUserController@recordUserAnimeStatus')->name('ajaxAnimeUser.post');


Route::get('/animes/search/{q?}', 'AnimesController@searchAnimes')->name('animes.search');
Route::resource('animes',AnimesController::class );

Route::get('/genres/{genre}', 'GenresController@index')->name('genres.index');

