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

Route::redirect('/', 'lk/object/edit')
  ->name('index');

Route::get('object/edit', 'ObjectController@edit')
  ->name('object.edit');
Route::post('object/update', 'ObjectController@update')
  ->name('object.update');
Route::post('object/image/upload', 'ObjectController@uploadFor')
  ->name('object.image.upload');
Route::post('object/image/delete/{image}', 'ObjectController@delete')
  ->name('object.image.delete');

Route::delete('room/delete/{id}', 'RoomController@deleteRoom')
  ->name('room.deleteRoom');

Route::get('room/edit', 'RoomController@edit')
  ->name('room.edit');
Route::post('room/create', 'RoomController@create')
  ->name('room.create');
Route::post('room/edit/fond', 'RoomController@fondUpdate')
  ->name('room.fond.update');
Route::post('room/save', 'RoomController@saveRoom')
  ->name('room.save');

Route::post('room/image/upload', 'RoomController@uploadFor')
  ->name('room.image.upload');
Route::post('room/image/delete/{image}', 'RoomController@delete')
  ->name('room.image.delete');

Route::get('room/attrs/{id}', 'RoomController@getAttributes')->name('room.attr.get');
Route::put('room/attrs/{id}', 'RoomController@putAttributes')->name('room.attr.put');

Route::put('category/update', 'CategoryController@update')
  ->name('category.update');
Route::post('category/create', 'CategoryController@create')
  ->name('category.create');
Route::delete('category/delete/{category}', 'CategoryController@delete')
  ->name('category.delete');

Route::get('instruction', 'InstructionController@index')->name('instruction.index');

Route::get('/staff', 'StaffController@index')->name('staff.index');
Route::delete('staff/remove/{id}', 'StaffController@remove')->name('staff.remove');
Route::post('staff/create', 'StaffController@create')->name('staff.create');
Route::put('staff/update/{id}', 'StaffController@update')->name('staff.update');
Route::post('staff/update/{id}/password', 'StaffController@generatePassword')->name('staff.update.password');