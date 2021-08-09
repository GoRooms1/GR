<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootBuilderMacroses();
        $this->makeDirectives();
    }

    private function bootBuilderMacroses()
    {
        \Illuminate\Database\Query\Builder::macro('toRawSql', function () {
            return array_reduce($this->getBindings(), function ($sql, $binding) {
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'{$binding}'", $sql, 1);
            }, $this->toSql());
        });

        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function () {
            return $this->getQuery()->toRawSql();
        });
    }

    private function makeDirectives()
    {
        Blade::directive('selected', function ($expression) {
            return "<?php echo \App\Providers\AppServiceProvider::setProp($expression, 'selected');?>";
        });
        Blade::directive('checked', function ($expression) {
            return "<?php echo \App\Providers\AppServiceProvider::setProp($expression, 'checked');?>";
        });
    }

    public static function setProp($first, $second, $prop)
    {
        if ($first == $second)
            return $prop;
        return '';
    }
}
