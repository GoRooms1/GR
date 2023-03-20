<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(?string $city)
 */
final class GetCityAreasAction extends Action
{
    /**
     * @param  string|null  $city
     * @return Collection
     */
    public function handle(?string $city): Collection
    {
        if (! isset($city)) {
            return new Collection();
        }

        return Address::distinct()->select('city_area', 'city')
            ->whereCity($city)->whereNotNull('city_area')
            ->orderBy('city_area')->get();
    }
}
