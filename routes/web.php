<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'Admin\HomeController@index')->name('home');

Route::get('/hotels', 'HotelController@index')->name('hotels.index');
Route::get('/hotels/{hotel}', 'HotelController@show')->name('hotels.show');
Route::get('/rooms', 'RoomController@index')->name('rooms.index');
Route::get('/rooms/hot', 'RoomController@hot')->name('rooms.hot');
Route::post('/rooms/{id}', 'RoomController@booking')->name('booking.room');
Route::get('/rooms/{room}', 'RoomController@show')->name('rooms.show');

Route::get('/blog', 'ArticleController@index')->name('articles.index');
Route::get('/blog/{article}', 'ArticleController@show')->name('articles.show');
Route::post('/form', 'FormController@store')->name('forms.store');
Route::get('/search', 'SearchController')->name('search');
Route::get('/search_map', 'SearchController')->name('search.map');
Route::get('/address/{city}/{area?}/{district?}/{street?}', 'SearchController@address')->name('search.address');
Route::get('/image/{path}', 'ImageController@show')->where('path', '.*');
Route::middleware('noDebugbar')->get('sitemap.xml', 'SiteMapController@index');
Route::get('/contacts', 'PageController@show')->name('pages.show');
Route::get('/bonuse', 'PageController@show')->name('pages.show');
Route::get('/rules', 'PageController@show')->name('pages.show');

Route::any('{error}', function () {
    return redirect()->to('/');
})->where('any', '.*');

Route::any('{page}/{error}', function () {
    return redirect()->to('{page}');
})->where('any', '.*');

