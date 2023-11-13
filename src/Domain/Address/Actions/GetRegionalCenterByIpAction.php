<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\DataTransferObjects\GeolocationData;
use Domain\Address\Models\RegionalCenter;
use Domain\Hotel\Models\Hotel;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(string $ip)
 */
final class GetRegionalCenterByIpAction extends Action
{
    
    /**     
     * @param ?string $ip
     * @return string
     */
    public function handle(?string $ip): string
    {
        $geoLocationData = GetLocationFromSession::run($ip);
        $regionalCenter = RegionalCenter::where('region', $geoLocationData->region)->first();

        if (is_null($regionalCenter))
            return  $geoLocationData->city;
        
        $region = $regionalCenter->region;
        $hotelInRegion = Hotel::whereHas('address', function ($q) use ($region) {
            $q->where('region', $region);
        })->count();    
        
        if ($hotelInRegion == 0)
            return  $geoLocationData->city;

        return $regionalCenter->city;
    }
}
