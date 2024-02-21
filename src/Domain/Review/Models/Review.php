<?php

namespace Domain\Review\Models;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use Domain\Hotel\Models\Hotel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\DataProcessing\Traits\ClearValidated;

/**
 *  Domain\Review\Models\Review
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
class Review extends Model implements HasMedia
{
    use ClearValidated;
    use CreatedAtOrdered;    
    use InteractsWithMedia;

    public const PER_PAGE = 6;

    protected $fillable = [
        'name',
        'city',
        'room',
        'text',
        'hotel_id',
        'room_id',
        'book_number',        
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',
    ];

    protected $with = [
        'ratings',
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

    public function registerMediaConversions(Media $media = null): void
    {       
        $this->addMediaConversion('card')
            ->nonQueued()
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 624, 306);
    }
}
