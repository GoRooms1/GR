<?php

namespace Domain\Category\Models;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use Domain\Category\DataTransferObjects\CategoryData;
use Domain\Category\Factories\CategoryFactory;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Room;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * Domain\Category\Models\Category
 *
 * @property int           $id
 * @property string        $name
 * @property string|null   $description
 * @property int           $hotel_id
 * @property int|null      $value
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property-read Hotel    $hotel
 * @property-read \Illuminate\Database\Eloquent\Collection<Room>|\Domain\Room\Models\Room[]     $rooms
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
    use HasFactory;
    use WithData;

    protected string $dataClass = CategoryData::class;

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
        return $this->hasMany(\Domain\Room\Models\Room::class);
    }

    public static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
