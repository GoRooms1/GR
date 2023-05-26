<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    protected string $admin_namespace = 'App\Http\Controllers\Admin';

    protected string $render_namespace = 'App\Http\Controllers';

    protected string $lk_namespace = 'App\Http\Controllers\Lk';

    protected string $moderator_namespace = 'App\Http\Controllers\Moderator';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapAdminRoutes();
        $this->mapLkRoutes();       
        $this->mapWebRoutes();
        $this->mapModeratorRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
          ->middleware(['api'])
          ->name('api.')
          ->group(base_path('routes/api.php'));
    }

    /**
     * Admin routes booting
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'auth', 'admin'])
          ->prefix('admin')
          ->name('admin.')
          ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
          ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "lk" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapLkRoutes(): void
    {
        Route::middleware(['web', 'auth', 'lk'])
          ->prefix('lk')
          ->name('lk.')
          ->group(base_path('routes/lk.php'));
    }

    /**
     * Define the "Moderator" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapModeratorRoutes(): void
    {
        Route::middleware(['web', 'auth', 'moderator'])
          ->prefix('moderator')
          ->name('moderator.')
          ->group(base_path('routes/moderator.php'));
    }
}
