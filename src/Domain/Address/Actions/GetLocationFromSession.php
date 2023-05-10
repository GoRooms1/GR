<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\DataTransferObjects\GeolocationData;
use Lorisleiva\Actions\Action;

/**
 * @method static GeolocationData run(string $ip)
 */
final class GetLocationFromSession extends Action
{
    
    /**     
     * @param ?string $ip
     * @return GeolocationData
     */
    public function handle(?string $ip): GeolocationData
    {
        if (session()->get('location', false)) {                
            /** @var GeolocationData*/
            return request()->session()->get('location', false);
        }
        
        if (config('app.env') === 'local')
            $ip = null;

        $geoLocationData = GetLocationByIp::run($ip);
        session()->put('location', $geoLocationData);        
        
        return $geoLocationData;
    }
}
