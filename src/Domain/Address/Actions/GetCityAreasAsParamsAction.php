<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static array run()
 */
final class GetCityAreasAsParamsAction extends Action
{
    public function handle($city): array
    {       
        if (!isset($city))
            return array();

        return Address::distinct()->select('city_area as key', 'city_area as name')
            ->whereCity($city)->whereNotNull('city_area')
            ->orderBy('city_area')->get()->toArray();          
    }
}
