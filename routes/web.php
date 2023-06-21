<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Lk;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SiteMapController;
use Domain\Search\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/hot', [RoomController::class, 'hot'])->name('rooms.hot');
Route::post('/rooms/booking', [RoomController::class, 'booking'])->name('rooms.booking');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/address/{city?}/{area?}/{district?}/{street?}', [AddressController::class, 'address'])->name('address');

Route::get('/contacts', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contacts', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

//Custom SEO pages
Route::get('/jacuzzi', [CustomPageController::class, 'jacuzzi'])->name('custom.jacuzzi');
Route::get('/centre', [CustomPageController::class, 'centre'])->name('custom.centre');
Route::get('/5minut', [CustomPageController::class, 'fiveMinut'])->name('custom.5minut');
Route::get('/lowcost', [CustomPageController::class, 'lowcost'])->name('custom.lowcost');

Route::get('/blog', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/blog/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::post('/form', [FormController::class, 'store'])->name('forms.store');

Route::get('sitemap.xml', [SiteMapController::class, 'index']);

Route::get('/bonuse', [PageController::class, 'show'])->name('pages.show');
Route::get('/rules', [PageController::class, 'show']);

Route::get('lk/start', [Lk\HomeController::class, 'start'])->name('lk.start');
Route::post('lk/object/store', [Lk\ObjectController::class, 'store'])->name('lk.object.store');