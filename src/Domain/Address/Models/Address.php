<?php

declare(strict_types=1);

namespace Domain\Address\Models;

use Domain\Address\Actions\GetUnitedCities;
use Domain\Address\Builders\AddressBuilder;
use Domain\Address\DataTransferObjects\AddressData;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Room;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;
use Support\DataProcessing\Traits\ClearValidated;

/**
 * Domain\Address\Models\Address
 *
 * @property int         $id
 * @property string|null $postal_code
 * @property string|null $country
 * @property string|null $region
 * @property string|null $area
 * @property string|null $city
 * @property string|null $street
 * @property string|null $house
 * @property string|null $block
 * @property string|null $flat
 * @property string|null $office
 * @property string|null $geo_lat
 * @property string|null $geo_lon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int         $hotel_id
 * @property string|null $value
 * @property string|null $city_district
 * @property string|null $city_area
 * @property string|null $street_type
 * @property string|null $street_with_type
 * @property string|null $comment
 * @property-read mixed  $city_area_short
 * @property-read ?Hotel  $hotel
 *
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @method static Builder|Address whereArea($value)
 * @method static Builder|Address whereBlock($value)
 * @method static Builder|Address whereCity($value)
 * @method static Builder|Address whereCityArea($value)
 * @method static Builder|Address whereCityDistrict($value)
 * @method static Builder|Address whereComment($value)
 * @method static Builder|Address whereCountry($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereFlat($value)
 * @method static Builder|Address whereGeoLat($value)
 * @method static Builder|Address whereGeoLon($value)
 * @method static Builder|Address whereHotelId($value)
 * @method static Builder|Address whereHouse($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereOffice($value)
 * @method static Builder|Address wherePostalCode($value)
 * @method static Builder|Address whereRegion($value)
 * @method static Builder|Address whereStreet($value)
 * @method static Builder|Address whereStreetType($value)
 * @method static Builder|Address whereStreetWithType($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereValue($value)
 * @mixin Eloquent
 */
final class Address extends Model
{
    use ClearValidated;
    use WithData;

    protected string $dataClass = AddressData::class;

    protected $fillable = [
        'postal_code',
        'country',
        'region',
        'area',
        'city',
        'city_district',
        'street',
        'house',
        'block',
        'flat',
        'office',
        'geo_lat',
        'geo_lon',
        'value',
        'street_type',
        'city_area',
        'street_with_type',
        'comment',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function rooms(): HasMany
    {
        return $this->HasMany(Room::class, 'hotel_id', 'hotel_id');
    }

    public function getCityAreaShortAttribute(): string
    {
        $areas = explode('-', $this->city_area ?? '');
        $area = '';
        foreach ($areas as $area_prefix) {
            $area .= mb_substr($area_prefix, 0, 1);
        }

        return mb_strtoupper($area).'АО';
    }

    public function unitedCities(): \Illuminate\Support\Collection
    {
        return GetUnitedCities::run($this->city);
    }

     /**
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return AddressBuilder<Address>
     */
    public function newEloquentBuilder($query): AddressBuilder
    {
        return new AddressBuilder($query);
    }
}
