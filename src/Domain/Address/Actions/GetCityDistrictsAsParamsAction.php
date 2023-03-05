<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static array run()
 */
final class GetCityDistrictsAsParamsAction extends Action
{
    public function handle($city, $city_area): array
    {       
        if (!isset($city))
            return array();

        return Address::distinct()->select('city_district as key', 'city_district as name')
            ->whereCity($city)->whereNotNull('city_district')
            ->when($city_area, function($q) use ($city_area) {
                return $q->where('city_area', $city_area);
            })->orderBy('city_district')->get()->toArray();          
    }
}
