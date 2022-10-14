<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index')->name('index');

Auth::routes();

Route::get('/hotels', 'HotelController@index')->name('hotels.index');
Route::get('/hotels/{hotel}', 'HotelController@show')->name('hotels.show');
Route::get('/rooms', 'RoomController@index')->name('rooms.index');
Route::get('/rooms/hot', 'RoomController@hot')->name('rooms.hot');
Route::post('/rooms/{id}', 'RoomController@booking')->name('booking.room');
Route::get('/rooms/{room}', 'RoomController@show')->name('rooms.show');

Route::get('/blog', 'ArticleController@index')->name('articles.index');
Route::get('/blog/{article}', 'ArticleController@show')->name('articles.show');
Route::post('/form', 'FormController@store')->name('forms.store');

Route::get('/search', 'SearchController_V2@index')->name('search');

Route::get('/search_map_old', 'SearchController')->name('search.map1');

Route::get('/search_map', 'SearchController_V2@map')->name('search.map');

Route::get('/address/{city}/{area?}/{district?}/{street?}', 'SearchController_V2@address')->name('search.address');

Route::get('/image/{path}', 'ImageController@show')->where('path', '.*');
Route::middleware('noDebugbar')->get('sitemap.xml', 'SiteMapController@index');
Route::get('/contacts', 'PageController@show')->name('pages.show');
Route::get('/bonuse', 'PageController@show');
Route::get('/rules', 'PageController@show');

Route::get('lk/start', 'Lk\HomeController@start')->name('lk.start');
Route::post('lk/object/store', 'Lk\ObjectController@store')->name('lk.object.store');

Route::get('/jacuzzi', 'CustomPageController@jacuzzi')->name('custom.jacuzzi');
Route::get('/centre', 'CustomPageController@centre')->name('custom.centre');
Route::get('/5minut', 'CustomPageController@fiveMinut')->name('custom.5minut');
Route::get('/lowcost', 'CustomPageController@lowcost')->name('custom.lowcost');
