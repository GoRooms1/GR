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
  public const HOME = '/home';
  /**
   * This namespace is applied to your controller routes.
   *
   * In addition, it is set as the URL generator's root namespace.
   *
   * @var string
   */
  protected $namespace = 'App\Http\Controllers';
  protected string $admin_namespace = 'App\Http\Controllers\Admin';
  protected string $render_namespace = 'App\Http\Controllers';

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
    $this->mapRenderRoutes();
    $this->mapWebRoutes();
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
      ->middleware(['api', 'noDebugbar'])
      ->name('api.')
      ->namespace($this->namespace)
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
      ->namespace($this->admin_namespace)
      ->group(base_path('routes/admin.php'));
  }

  protected function mapRenderRoutes(): void
  {
    Route::prefix('render')
      ->middleware(['web', 'noDebugbar'])
      ->name('render.')
      ->namespace($this->render_namespace)
      ->group(base_path('routes/render.php'));
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
      ->namespace($this->namespace)
      ->group(base_path('routes/web.php'));
  }
}
