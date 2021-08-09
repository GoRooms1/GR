<?php

namespace App\Http\Middleware;

use App\Models\Address;
use App\Settings;
use Closure;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class SetCityCoords
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        self::set($request);
        return $next($request);
    }

    public static function set(Request $request)
    {
        $city = $request->session()->get('city', Settings::option('city_default', null));
        if (Settings::option('city_default', false) || $request->session()->get('city', false)) {
            if (!$request->session()->get('city', false)) {
                $city = self::getCenterCoords(\Request::ip())['city'];
                if (Address::where('city', $city)->first() === null)
                    $city = Settings::option('city_default', 'Москва');
                $request->session()->put('city', $city);
            }
            $query = "г. $city";
            $from_db = DB::table('city_coords')->where('query', '=', $query)->first();
            if ($from_db) {
                $search_address = [
                    'lat' => $from_db->lat,
                    'lon' => $from_db->lon,
                ];
            } else {
                try {
                    $data = DadataSuggest::suggest('address', ['query' => $query, 'count' => 1]);
                    $search_address = [
                        'lat' => $data['data']['geo_lat'],
                        'lon' => $data['data']['geo_lon'],
                    ];
                    DB::table('city_coords')->insert(array_merge(['query' => $query], $search_address));
                } catch (\Exception $exception) {
                    Log::error($exception);
                    $search_address = self::getCenterCoords(\Request::ip());
                }
            }
        } else {
            $search_address = self::getCenterCoords(\Request::ip());
        }
        View::share('current_city', isset($city) ? $city : '');
        View::share('search_address', $search_address);
    }

    public static function getCenterCoords(string $ip):array
    {
        try {
            $response = file_get_contents('http://api.sypexgeo.net/json/' . $ip);
            $object = json_decode($response);

            return [
                'city' => $object->city->name_ru,
                'lat' => $object->city->lat,
                'lon' => $object->city->lon
            ];
        } catch (\Exception $exception) {
            return [
                'city' => Settings::option('city_default', 'Москва'),
                'lat' => 55.753018,
                'lon' => 37.619251
            ];
        }
    }
}
