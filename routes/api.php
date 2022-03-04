<?php

use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::match(['GET', 'POST'], '/search', 'SearchController')->name('search');
//Route::match(['GET', 'POST'], '/search_map', 'SearchController')->name('search.map');
Route::post('search', 'Api\SearchController@index')->name('search.index');
Route::post( '/search_map', 'Api\SearchController@map')->name('search.map');

Route::get('/address/helper', 'Api\AddressController@helper');

Route::get('/room-info/{id}', [RoomController::class, 'getRoomInfo']);

// Для изменения порядка показа комнат в отеле
Route::post('room/order/up/{id}', 'Lk\OrderRoomController@upOrder');
Route::post('room/order/down/{id}', 'Lk\OrderRoomController@downOrder');

// Для изменения порядка фотографий в комнате и отеле, ЛК
Route::post('images/ordered', [ImageController::class, 'ordered']);

Route::prefix('/filter')->name('filter.')->group(function () {
  Route::get('cities', 'Api\FilterController@cities')->name('cities');
  Route::get('city-area', 'Api\FilterController@city_area')->name('city_area');
  Route::get('count-city-area', 'Api\FilterController@count_city_area')->name('count_city_area');
  Route::get('district', 'Api\FilterController@district')->name('district');
  Route::get('metro', 'Api\FilterController@metro')->name('metro');

  Route::get('all', 'Api\FilterController@all')->name('all');
});