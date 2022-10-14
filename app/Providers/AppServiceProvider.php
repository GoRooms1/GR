<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public static function setProp($first, $second, $prop)
    {
        if ($first === $second) {
            return $prop;
        }

        return '';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        $this->makeDirectives();
    }

    private function makeDirectives()
    {
        Blade::directive('selected', function ($expression) {
            return "<?php echo \App\Providers\AppServiceProvider::setProp($expression, 'selected');?>";
        });
        Blade::directive('checked', function ($expression) {
            return "<?php echo \App\Providers\AppServiceProvider::setProp($expression, 'checked');?>";
        });

        Blade::directive('moderator', function () {
            return '<?php if (auth()->check()) {
        if (auth()->user()->is_moderate) { ?>';
        });

        Blade::directive('endmoderator', function () {
            return '<?php } } ?>';
        });
    }
}
