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