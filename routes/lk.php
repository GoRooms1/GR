<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "lk" middleware group. Now create something great!
|
*/

Route::redirect('/', 'lk/object/edit')->name('index');

Route::get('object/edit', 'ObjectController@edit')->name('object.edit');
Route::post('object/update', 'ObjectController@update')->name('object.update');
Route::post('object/image/upload', 'ObjectController@uploadFor')->name('object.image.upload');
Route::post('object/image/delete/{image}', 'ObjectController@delete')->name('object.image.delete');

Route::get('room/edit', 'RoomController@edit')->name('room.edit');
Route::post('room/edit/fond', 'RoomController@fondUpdate')->name('room.fond.update');

Route::put('category/update', 'CategoryController@update')->name('category.update');
Route::post('category/create', 'CategoryController@create')->name('category.create');
Route::delete('category/delete', 'CategoryController@delete')->name('category.delete');