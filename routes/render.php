<?php

use Illuminate\Support\Facades\Route;

Route::match(['GET', 'POST'], '/search', 'SearchController')->name('search');
Route::match(['GET', 'POST'], '/search_map', 'SearchController')->name('search.map');

Route::match(['GET', 'POST'], '/hotels/{hotel}', 'Render\HotelController@show')->name('hotels.show');
Route::match(['GET', 'POST'], '/hotels', 'Render\HotelController@index')->name('hotels.index');
Route::match(['GET', 'POST'], '/rooms', 'Render\RoomController@index')->name('rooms.index');
Route::match(['GET', 'POST'], '/rooms/hot', 'Render\RoomController@hot')->name('rooms.hot');
