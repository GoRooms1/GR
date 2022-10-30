<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use App\Models\UnitedCity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<string> run(?string $city)
 */
final class GetUnitedCities extends Action
{
    public function handle(?string $city): Collection
    {
        if (! $city) {
            return collect();
        }
        $row = DB::table('united_cities_address')->where('city_name', $city)->first();
        if ($row) {
            $unitedCity = UnitedCity::find($row->united_city);
            if ($unitedCity) {
                return $unitedCity->united();
            }
        }

        return collect([
            $city,
        ]);
    }
}
