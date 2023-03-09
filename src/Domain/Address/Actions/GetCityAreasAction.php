<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetCityAreasAction extends Action
{
    public function handle($city): Collection
    {       
        if (!isset($city))
            return array();

        return Address::distinct()->select('city_area', 'city')
            ->whereCity($city)->whereNotNull('city_area')
            ->orderBy('city_area')->get();          
    }
}
