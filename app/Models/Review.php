<?php

namespace App\Models;

use App\Parents\Model;
use App\Traits\ClearValidated;
use App\Traits\CreatedAtOrdered;
use Domain\Hotel\Models\Hotel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Review
 *
 * @property int                      $id
 * @property string                   $name
 * @property string                   $city
 * @property string                   $room
 * @property string                   $text
 * @property int                      $hotel_id
 * @property int|null                 $user_id
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property-read Hotel               $hotel
 * @property-read Collection|Rating[] $ratings
 * @property-read int|null            $ratings_count
 *
 * @method static Builder|Review newModelQuery()
 * @method static Builder|Review newQuery()
 * @method static Builder|Review query()
 * @method static Builder|Review whereCity($value)
 * @method static Builder|Review whereCreatedAt($value)
 * @method static Builder|Review whereHotelId($value)
 * @method static Builder|Review whereId($value)
 * @method static Builder|Review whereName($value)
 * @method static Builder|Review whereRoom($value)
 * @method static Builder|Review whereText($value)
 * @method static Builder|Review whereUpdatedAt($value)
 * @method static Builder|Review whereUserId($value)
 * @mixin Eloquent
 */
class Review extends Model
{
    use ClearValidated;
    use CreatedAtOrdered;

    public const PER_PAGE = 6;

    protected $fillable = [
        'name',
        'city',
        'room',
        'text',
        'hotel_id',
    ];

    public function ratings(): HasMany
    {
        return $this
          ->hasMany(Rating::class)
          ->with('category');
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
