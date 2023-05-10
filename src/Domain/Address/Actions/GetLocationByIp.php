<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use DB;
use Domain\Address\DataTransferObjects\GeolocationData;
use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Action;

/**
 * @method static GeolocationData run(string $ip)
 */
final class GetLocationByIp extends Action
{
    
    /**     
     * @param ?string $ip
     * @return GeolocationData
     */
    public function handle(?string $ip): GeolocationData
    {        
        $geoLocationData = self::getLocationFromDaData($ip);
        if (!is_null($geoLocationData))
            return $geoLocationData;

        $geoLocationData = self::getLocationFromSypexgeo($ip);
        if (!is_null($geoLocationData))
            return $geoLocationData;        
        
        return GeolocationData::default();
    }

    /**     
     * @param ?string $ip
     * @return GeolocationData|null
     */
    private function getLocationFromDaData(?string $ip): GeolocationData | null
    {
        if (is_null($ip))
            return null;        
        
        try {
            $response = Http::asJson()->withHeaders([
                'Authorization' => 'Token '.config('dadata.token'),
                'X-Secret' => config('dadata.secret')
            ])->post(config('dadata.iplocate_url'), [
                'ip' => $ip,            
            ]);
    
            if (!$response->successful())
                return null;
            
            $data = $response->collect()->toArray();        
    
            if ($data['location'] == null || $data['location'] == 'null')
                return null;
            
            $geoLocationData = GeolocationData::fromDaData($data, $ip);
            self::saveResultInDB($geoLocationData);

            return $geoLocationData;
        }
        catch (Exception $e) {
            return null;
        }
    }

    /**     
     * @param ?string $ip
     * @return GeolocationData|null
     */
    private function getLocationFromSypexgeo(?string $ip): GeolocationData | null
    {       
        try {
            $response = Http::asJson()->get('http://api.sypexgeo.net/json/'.($ip ?? ''));

            if (!$response->successful())
                return null;
            
            $data = $response->collect()->toArray();        

            if ($data['city'] == null || $data['city'] == 'null')
                return null;

            $geoLocationData = GeolocationData::fromSypexgeo($data);
            self::saveResultInDB($geoLocationData);

            return $geoLocationData;
        }
        catch (Exception $e) {
            return null;
        }
    }

    /**     
     * @param GeolocationData $geoLocationData
     * @return void
     */
    private function saveResultInDB(GeolocationData $geoLocationData) {
        try {
            DB::table('city_coords')->insert([
                'query' => 'г. '.$geoLocationData->city,
                'lat' => $geoLocationData->geo_lat,
                'lon' => $geoLocationData->geo_lon,
            ]);
        }
        catch (Exception $e) {}
    }
}
