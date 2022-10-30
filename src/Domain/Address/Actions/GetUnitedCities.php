<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use App\Models\UnitedCity;
use Illuminate\Database\Eloquent\Model;
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
            return collect([]);
        }
        /** @var ?Model $row */
        $row = DB::table('united_cities_address')->where('city_name', $city)->first();
        if ($row) {
            /** @var ?UnitedCity $unitedCity */
            $unitedCity = UnitedCity::find($row->united_city); /** @phpstan-ignore-line */
            if ($unitedCity) {
                return $unitedCity->united();
            }
        }

        return collect([
            $city,
        ]);
    }
}
