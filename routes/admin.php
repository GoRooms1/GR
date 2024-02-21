<?php

use App\Http\Controllers\Admin\AdBannerController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AttributeCategoriesController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BotMessageTemplateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CostTypeController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\HotelTypeController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\InstructionController;
use App\Http\Controllers\Admin\MenuCostsController;
use App\Http\Controllers\Admin\ModeratorController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageDescriptionController;
use App\Http\Controllers\Admin\PageDescriptionPageController;
use App\Http\Controllers\Admin\RatingCategoryController;
use App\Http\Controllers\Admin\RegionalCenterController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UnitedCityController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::resource('hotels', HotelController::class);
Route::resource('rooms', RoomController::class)->except('create');
Route::get('/rooms/create/{hotel}', [RoomController::class, 'create'])->name('rooms.create');

Route::resource('attributes', AttributeController::class)->except(['show']);

Route::resource('attribute_categories', AttributeCategoriesController::class);

Route::resource('hotels/{hotel?}/categories', CategoryController::class)->except('index');
Route::resource('cost_types', CostTypeController::class)->except('show');

Route::resource('bookings', BookingController::class)->except('destroy', 'create', 'update', 'edit', 'store');

Route::resource('hotel_types', HotelTypeController::class)->except('show');
Route::resource('ratings', RatingCategoryController::class)->except('show');

Route::resource('hotels/{hotel}/reviews', ReviewController::class);
Route::resource('pages', PageController::class)->except('show');
Route::resource('articles', ArticleController::class)->except('show');

Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('settings/seo', [SettingsController::class, 'seo'])->name('settings.seo');
Route::get('settings/seo/edit/{id}', [SettingsController::class, 'seoEdit'])->name('settings.seo.edit');
Route::put('settings/seo/update/{id}', [SettingsController::class, 'seoUpdate'])->name('settings.seo.update');
Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');
Route::post('settings/robot', [SettingsController::class, 'storeRobot'])->name('settings.robot_store');

Route::prefix('/settings')->name('settings.')->group(function () {
    Route::prefix('/menu-costs')->name('menu-costs.')->group(function () {
        Route::get('/', [MenuCostsController::class, 'index'])->name('index');
        Route::post('/save', [MenuCostsController::class, 'save'])->name('save');
    });
});

Route::resource('forms', FormController::class)->only('index', 'show');

Route::resource('descriptions', PageDescriptionController::class)->except('show');

Route::resource('descriptions-page', PageDescriptionPageController::class)->except('show');

Route::prefix('api')->group(function () {
    Route::delete('/image/{image}', [ImageController::class, 'delete'])->name('api.image.delete');
});

Route::match(['GET', 'POST'], '/upload', [ImageController::class, 'upload']);
Route::match(['GET', 'POST'], '/upload_for/', [ImageController::class, 'uploadFor']);

Route::get('/clear-cache', [SettingsController::class, 'clearCache'])->name('clear-cache');
Route::get('/update-address-slugs', [PageDescriptionController::class, 'updateAddressSlugs'])->name('update-address-slugs');

Route::post('/periods/updateByJson', [PeriodController::class, 'updateByJson'])->name('periods.update.json');

Route::resource('moderators', ModeratorController::class);

Route::resource('instructions', InstructionController::class);

Route::resource('united_cities', UnitedCityController::class);

Route::resource('regional_centers', RegionalCenterController::class)->except('show');

Route::resource('bot_message_templates', BotMessageTemplateController::class)->except('show');
Route::post('bot_message_templates/{botMessageTemplate}/send_test', [BotMessageTemplateController::class, 'sendTest'])->name('bot_message_templates.send-test');
Route::post('bot_message_templates/{botMessageTemplate}/send_onetime', [BotMessageTemplateController::class, 'sendOnetime'])->name('bot_message_templates.send-onetime');

Route::resource('ad_banners', AdBannerController::class)->except('show');

Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');