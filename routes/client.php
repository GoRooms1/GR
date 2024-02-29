<?php

use App\Http\Controllers\Client\BookingsController;
use App\Http\Controllers\Client\DeleteController;
use App\Http\Controllers\Client\FavoritesController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Client\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "client" middleware group. Now create something great!
|
*/

Route::redirect('/', 'client/settings')
  ->name('index');

Route::get('settings', [SettingsController::class, 'index'])
  ->name('settings.index');

Route::post('settings/update', [SettingsController::class, 'update'])
  ->name('settings.update');

Route::post('/delete/resend', [DeleteController::class, 'resend'])
  ->name('delete.resend');

Route::get('favorites', [FavoritesController::class, 'index'])
  ->name('favorites');

Route::get('bookings', [BookingsController::class, 'index'])
  ->name('bookings');

Route::put('bookings/{booking}/cancel', [BookingsController::class, 'cancel'])
  ->name('bookings.cancel');

Route::post('/review', [ReviewController::class, 'create'])
  ->name('review.create');
