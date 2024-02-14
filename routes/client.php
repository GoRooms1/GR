<?php

use App\Http\Controllers\Client\FavoritesController;
use App\Http\Controllers\Client\SettingsController;
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

Route::redirect('/', 'client/settings')
  ->name('index');

Route::get('settings', [SettingsController::class, 'index'])
  ->name('settings');

  Route::get('favorites', [FavoritesController::class, 'index'])
  ->name('favorites');
