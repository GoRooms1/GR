<?php

declare(strict_types=1);

namespace Domain\Room\Models;

use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use Domain\Attribute\Model\Attribute;
use Domain\Hotel\Models\Hotel;
use Domain\Image\Models\Image;
use Domain\Image\Traits\UseImages;
use Domain\PageDescription\Models\PageDescription;
use Domain\Room\Actions\GetAllRoomCosts;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Room\Factories\RoomFactory;
use Domain\Room\Scopes\RoomModerationScope;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\LaravelData\WithData;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Domain\Room\Models\Room
 *
 * @property int                         $id
 * @property ?string                 $name
 * @property int|null                    $number
 * @property int|null                    $order
 * @property int|null                    $category_id
 * @property bool                        $moderate
 * @property string|null                 $description
 * @property int                         $hotel_id
 * @property string|null                 $deleted_at
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property bool                        $is_hot
 * @property-read Collection<Attribute>|Attribute[] $attrs
 * @property-read int|null               $attrs_count
 * @property-read \Domain\Category\Models\Category|null          $category
 * @property-read Collection<Cost>|Cost[]      $costs
 * @property-read int|null               $costs_count
 * @property-read \Illuminate\Support\Collection<\Domain\Room\DataTransferObjects\CostData>                  $all_costs
 * @property-read string|null            $meta_description
 * @property-read string|null            $meta_keywords
 * @property-read string|null            $meta_title
 * @property-read Hotel                  $hotel
 * @property-read \Domain\Image\Models\Image                  $image
 * @property-read Collection|Image[]     $images
 * @property-read int|null               $images_count
 * @property-read PageDescription|null   $meta
 *
 * @method static Builder|Room hot()
 * @method static Builder|Room newModelQuery()
 * @method static Builder|Room newQuery()
 * @method static Builder|Room query()
 * @method static Builder|Room whereCategoryId($value)
 * @method static Builder|Room whereCreatedAt($value)
 * @method static Builder|Room whereDeletedAt($value)
 * @method static Builder|Room whereDescription($value)
 * @method static Builder|Room whereHotelId($value)
 * @method static Builder|Room whereId($value)
 * @method static Builder|Room whereIsHot($value)
 * @method static Builder|Room whereModerate($value)
 * @method static Builder|Room whereName($value)
 * @method static Builder|Room whereNumber($value)
 * @method static Builder|Room whereOrder($value)
 * @method static Builder|Room whereUpdatedAt($value)
 * @mixin Eloquent
 */
final class Room extends Model implements HasMedia
{
    use UseImages;
    use InteractsWithMedia;
    use CreatedAtOrdered;
    use HasFactory;
    use WithData;

    public const PER_PAGE = 6;

    protected string $dataClass = RoomData::class;

    public string $no_image = 'img/img-room-sm-1.jpg';

    protected $fillable = [
        'name',
        'number',
        'order',
        'moderate',
        'description',
        'is_hot',
    ];

    protected $casts = [
        'moderate' => 'boolean',
        'is_hot' => 'boolean',
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'attrs',
        'media',
        'costs',
        'hotel',
        'category',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::addGlobalScope(new RoomModerationScope());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(\Domain\Category\Models\Category::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_room', 'room_id', 'attribute_id');
    }

    /**
     * @return   \Spatie\LaravelData\DataCollection
     *
     * @deprecated Use action instead
     */
    public function getAllCostsAttribute(): \Spatie\LaravelData\DataCollection
    {
        return GetAllRoomCosts::run($this);
    }

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, 'room_id', 'id');
    }    

    public function meta(): HasOne
    {
        return $this
          ->hasOne(PageDescription::class, 'model_id')
          ->where('model_type', self::class);
    }

    public function getMetaDescriptionAttribute(): ?string
    {
        return $this->meta->meta_description ?? null;
    }

    public function getMetaKeywordsAttribute(): ?string
    {
        return $this->meta->meta_keywords ?? null;
    }

    public function getMetaTitleAttribute(): ?string
    {
        return $this->meta->title ?? null;
    }

    protected static function newFactory(): RoomFactory
    {
        return RoomFactory::new();
    }

    /**
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return RoomBuilder<Room>
     */
    public function newEloquentBuilder($query): RoomBuilder
    {
        return new RoomBuilder($query);
    }

    public function registerMediaConversions(Media $media = null): void
    {       
        $this->addMediaConversion('card')
            ->nonQueued()
            ->format(Manipulations::FORMAT_WEBP)
            ->crop(Manipulations::CROP_CENTER, 624, 306);
    }
}
