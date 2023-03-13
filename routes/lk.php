<?php

use App\Http\Controllers\Lk\CategoryController;
use App\Http\Controllers\Lk\InstructionController;
use App\Http\Controllers\Lk\ObjectController;
use App\Http\Controllers\Lk\StaffController;
use App\Http\Controllers\RoomController;
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

Route::get('object/edit', [ObjectController::class, 'edit'])
  ->name('object.edit');
Route::post('object/update', [ObjectController::class, 'update'])
  ->name('object.update');
Route::post('object/image/upload', [ObjectController::class, 'uploadFor'])
  ->name('object.image.upload');
Route::post('object/image/delete/{image}', [ObjectController::class, 'delete'])
  ->name('object.image.delete');

Route::delete('room/delete/{id}', [RoomController::class, 'deleteRoom'])
  ->name('room.deleteRoom');

Route::get('room/edit', [RoomController::class, 'edit'])
  ->name('room.edit');
Route::post('room/create', [RoomController::class, 'create'])
  ->name('room.create');
Route::post('room/edit/fond', [RoomController::class, 'fondUpdate'])
  ->name('room.fond.update');
Route::post('room/save', [RoomController::class, 'saveRoom'])
  ->name('room.save');

Route::post('room/image/upload', [RoomController::class, 'uploadImage'])
  ->name('room.image.upload');
Route::post('room/image/delete/{image}', [RoomController::class, 'delete'])
  ->name('room.image.delete');

Route::get('room/attrs/{id}', [RoomController::class, 'getAttributes'])->name('room.attr.get');
Route::put('room/attrs/{id}', [RoomController::class, 'putAttributes'])->name('room.attr.put');

Route::put('category/update', [CategoryController::class, 'update'])
  ->name('category.update');
Route::post('category/create', [CategoryController::class, 'create'])
  ->name('category.create');
Route::delete('category/delete/{category}', [CategoryController::class, 'delete'])
  ->name('category.delete');

Route::get('instruction', [InstructionController::class, 'index'])->name('instruction.index');

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::delete('staff/remove/{id}', [StaffController::class, 'remove'])->name('staff.remove');
Route::post('staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::put('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::post('staff/update/{id}/password', [StaffController::class, 'generatePassword'])->name('staff.update.password');
