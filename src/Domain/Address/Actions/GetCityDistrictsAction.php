<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetCityDistrictsAction extends Action
{
    public function handle($city, $city_area): Collection
    {       
        if (!isset($city))
            return array();

        return Address::distinct()->select('city_district')
            ->whereCity($city)->whereNotNull('city_district')
            ->when($city_area, function($q) use ($city_area) {
                return $q->where('city_area', $city_area);
            })->orderBy('city_district')->get();          
    }
}
