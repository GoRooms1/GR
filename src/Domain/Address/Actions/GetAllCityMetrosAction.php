<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(?string $city, ?string $area, ?string $district)
 */
final class GetAllCityMetrosAction extends Action
{
    /**
     * @param  string|null  $city
     * @param  string|null  $area
     * @param  string|null  $district
     * @return Collection
     */
    public function handle(?string $city, ?string $area, ?string $district): Collection
    {
        if (! $city) {
            return new Collection();
        } else {
            return Metro::distinctName()->select('name', 'color', 'api_value')
                ->whereCity($city)
                ->when($area, function($q) use ($area) {                   
                    $q->whereArea($area);
                })
                ->when($district, function($q) use ($district) {
                    $q->whereDistrict($district);
                })
                ->ordered()->get();
        }
    }
}
