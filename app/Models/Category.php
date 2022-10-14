<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int           $id
 * @property string        $name
 * @property string|null   $description
 * @property int           $hotel_id
 * @property int|null      $value
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property-read Hotel    $hotel
 * @property-read Room     $rooms
 * @property-read int|null $rooms_count
 *
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereHotelId($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereValue($value)
 * @mixin Eloquent
 */
class Category extends Model
{
    use CreatedAtOrdered;

    /**
     * rows
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'hotel_id',
    ];

    /**
     * return Hotel
     *
     * @return BelongsTo
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * return Rooms
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
