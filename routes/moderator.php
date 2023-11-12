<?php

use App\Http\Controllers\Moderator\CostsCalendarController;
use App\Http\Controllers\Moderator\ImageController;
use App\Http\Controllers\Moderator\CategoryController;
use App\Http\Controllers\Moderator\InstructionController;
use App\Http\Controllers\Moderator\ObjectController;
use App\Http\Controllers\Moderator\StaffController;
use App\Http\Controllers\Moderator\RoomController;
use Illuminate\Support\Facades\Route;

/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

Route::get('/hotel/{id}', [ObjectController::class, 'edit'])->name('object.edit');
Route::post('/hotel/{id}', [ObjectController::class, 'update'])->name('object.update');

Route::post('/hotel/{id}/upload', [ObjectController::class, 'upload'])->name('object.upload');
Route::post('/hotel/{id}/unupload', [ObjectController::class, 'unupload'])->name('object.unupload');

Route::delete('/image/{image}', [ImageController::class, 'delete'])->name('image.delete');
Route::post('/image/moderate/{image}', [ImageController::class, 'moderate'])->name('image.moderate');

Route::get('/hotel/{id}/rooms', [RoomController::class, 'edit'])->name('room.edit');
Route::post('/room/update', [RoomController::class, 'update'])->name('room.update');

Route::delete('room/delete/{id}', [RoomController::class, 'delete'])->name('room.delete');

Route::put('category/update', [CategoryController::class, 'update'])
  ->name('category.update');
Route::post('category/create', [CategoryController::class, 'create'])
  ->name('category.create');
Route::delete('category/delete/{category}', [CategoryController::class, 'delete'])
  ->name('category.delete');

Route::get('room/attrs/{id}', [RoomController::class, 'getAttributes'])->name('room.attr.get');
Route::put('room/attrs/{id}', [RoomController::class, 'putAttributes'])->name('room.attr.put');
Route::post('room/published/{id}', [RoomController::class, 'published'])->name('room.published');
Route::get('room/attrs/{id}', [RoomController::class, 'getAttributes'])->name('room.attr.get');

Route::get('instruction/{id}', [InstructionController::class, 'index'])->name('instruction.index');

Route::post('staff/create-user/{id}', [StaffController::class, 'create'])->name('staff.create');
Route::get('hotel/{id}/staff', [StaffController::class, 'index'])->name('staff.index');
Route::delete('staff/remove/{staff_id}', [StaffController::class, 'remove'])->name('staff.remove');
Route::put('staff/update/{staff_id}', [StaffController::class, 'update'])->name('staff.update');
Route::post('staff/update/{staff_id}/password', [StaffController::class, 'generatePassword'])->name('staff.update.password');

Route::get('/cost/{id}/costs-calendar', [CostsCalendarController::class, 'getCostsCalendarByCostId'])->name('cost-calendar.get');
Route::post('/costs-calendar', [CostsCalendarController::class, 'create'])->name('cost-calendar.create');
Route::delete('/costs-calendar/{id}', [CostsCalendarController::class, 'destroy'])->name('cost-calendar.destroy');
