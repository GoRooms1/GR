<?php

declare(strict_types=1);

namespace Domain\Hotel\Models;

use Domain\Hotel\DataTransferObjects\HotelTypeData;
use Domain\Hotel\Factories\HotelTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * Domain\Hotel\Models\HotelType
 *
 * @property int                     $id
 * @property string                  $name
 * @property string|null             $description
 * @property int                     $sort
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property string|null             $single_name
 * @property-read Collection<Hotel>|Hotel[] $hotels
 * @property-read int|null           $hotels_count
 *
 * @method static Builder|HotelType newModelQuery()
 * @method static Builder|HotelType newQuery()
 * @method static Builder|HotelType query()
 * @method static Builder|HotelType whereCreatedAt($value)
 * @method static Builder|HotelType whereDescription($value)
 * @method static Builder|HotelType whereId($value)
 * @method static Builder|HotelType whereName($value)
 * @method static Builder|HotelType whereSingleName($value)
 * @method static Builder|HotelType whereSort($value)
 * @method static Builder|HotelType whereUpdatedAt($value)
 * @mixin Eloquent
 */
final class HotelType extends Model
{
    use HasFactory;
    use WithData;

    protected string $dataClass = HotelTypeData::class;

    protected $fillable = [
        'name',
        'description',
        'sort',
    ];

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public static function newFactory(): HotelTypeFactory
    {
        return HotelTypeFactory::new();
    }
}
