<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Lk;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

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


//old
/*
//Route::match(['GET', 'POST'], '/search', 'SearchController')->name('search');
//Route::match(['GET', 'POST'], '/search_map', 'SearchController')->name('search.map');
Route::post('search', [Api\SearchController::class, 'index'])->name('search.index');
Route::post('/search_map', [Api\SearchController::class, 'map'])->name('search.map');

Route::get('/address/helper', [Api\AddressController::class, 'helper']);

Route::get('/room-info/{id}', [RoomController::class, 'getRoomInfo']);

// Для изменения порядка показа комнат в отеле
Route::post('room/order/up/{id}', [Lk\OrderRoomController::class, 'upOrder']);
Route::post('room/order/down/{id}', [Lk\OrderRoomController::class, 'downOrder']);

// Для изменения порядка фотографий в комнате и отеле, ЛК
Route::post('images/ordered', [ImageController::class, 'ordered']);

// Route::prefix('/filter')->name('filter.')->group(function () {
//     Route::get('cities', [Api\FilterController::class, 'cities'])->name('cities');
//     Route::get('city-area', [Api\FilterController::class, 'city_area'])->name('city_area');
//     Route::get('count-city-area', [Api\FilterController::class, 'count_city_area'])->name('count_city_area');
//     Route::get('district', [Api\FilterController::class, 'district'])->name('district');
//     Route::get('metro', [Api\FilterController::class, 'metro'])->name('metro');

//     Route::get('all', [Api\FilterController::class, 'all'])->name('all');
// });
*/