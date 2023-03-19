<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(string|null $city, string|null $city_area)
 */
final class GetCityDistrictsAction extends Action
{   
    /**    
     * @param string|null $city
     * @param string|null $city_area
     * @return Collection
     */
    public function handle(?string $city, ?string $city_area): Collection
    {
        if (! isset($city))
            return new Collection();        

        return Address::distinct()->select('city_district')
            ->whereCity($city)->whereNotNull('city_district')
            ->when($city_area, function ($q) use ($city_area) {
                return $q->where('city_area', $city_area);
            })->orderBy('city_district')->get();
    }
}
