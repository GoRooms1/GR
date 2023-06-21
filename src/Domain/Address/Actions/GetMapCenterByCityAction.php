<?php

declare(strict_types=1);

namespace Domain\Address\Actions;


use Domain\Address\DataTransferObjects\GeolocationData;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

/**
 * @method static GeolocationData run(?string $city)
 */
final class GetMapCenterByCityAction extends Action
{
    
    /**     
     * @param ?string $city
     * @return GeolocationData | null
     */
    public function handle(?string $city): GeolocationData | null
    {
        if (is_null($city))
            return null;
        
        $cityCoords = DB::table('city_coords')->select()->where('query', 'г. '.$city)->first();
        if (is_null($cityCoords))
            return null;
        
        return new GeolocationData(
            city: $city,
            geo_lat: $cityCoords->lat,
            geo_lon: $cityCoords->lon,
            ip: null,
        );
    }
}
