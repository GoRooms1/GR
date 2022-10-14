<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\PageDescription;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ViewProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (! env('LOCAL', false)) {
//            $search_region = Address::groupBy('region')->pluck('region')->toArray();
//            $search_area = Address::groupBy('city_district')->pluck('city_district')->toArray();
//            $search_city = Address::groupBy('city')->pluck('city')->toArray();
//            $search_street = Address::groupBy('street')->pluck('street')->toArray();
//
//            View::share('search_region', $search_region);
//            View::share('search_area', $search_area);
//            View::share('search_city', $search_city);
//            View::share('search_street', $search_street);

            $url = url()->current();
            $url = str_replace(['https://', 'http://'], '', $url);
            $url = explode('/', $url);
            unset($url[0]);
            $url = implode('/', $url);
            $url = empty($url) ? '/' : $url;
            $url = str_replace('//', '/', '/'.$url);

            $pageDescription = PageDescription::where('url', $url)->whereNull('model_type')->first();
            View::share('pageDescription', $pageDescription);
        }
        Blade::directive('area', function (string $area) {
            $area_name = Str::ucfirst($area);
            $area_name = $area_name[0];

            return "<?php echo $area_name.'АО'?>";
        });
    }
}
