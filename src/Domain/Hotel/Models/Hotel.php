<?php

declare(strict_types=1);

namespace Domain\Hotel\Models;

use App\Models\Rating;
use App\Models\Review;
use App\Parents\Model;
use App\Traits\CreatedAtOrdered;
use App\User;
use Domain\Address\Actions\SaveHotelAddress;
use Domain\Address\Models\Address;
use Domain\Attribute\Model\Attribute;
use Domain\Category\Models\Category;
use Domain\Hotel\Actions\GenerateSlugForHotel;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Casts\PhoneNumberCast;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Hotel\Factories\HotelFactory;
use Domain\Hotel\Scopes\ModerationScope;
use Domain\Hotel\ValueObjects\PhoneNumberValueObject;
use Domain\Image\Traits\UseImages;
use Domain\Page\Actions\GenerateSeoDataContent;
use Domain\Page\DataTransferObjects\SeoData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\PageDescription\Models\PageDescription;
use Domain\Room\Models\Room;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\WithData;
use Support\DataProcessing\Traits\ClearValidated;

/**
 * Domain\Hotel\Models\Hotel
 *
 * @property int                                                       $id
 * @property string                                                    $name
 * @property string|null                                               $description
 * @property ?PhoneNumberValueObject                                   $phone
 * @property string|null                                               $phone_2
 * @property ?string                                                    $type_fond
 * @property int                                                       $user_id
 * @property Carbon|null                                               $created_at
 * @property Carbon|null                                               $updated_at
 * @property int                                                       $is_popular
 * @property int|null                                                  $type_id
 * @property string|null                                               $route
 * @property bool                                                      $old_moderate
 * @property bool                                                      $show
 * @property bool                                                      $moderate
 * @property ?string                                                    $route_title
 * @property string|null                                               $slug
 * @property int                                                       $hide_phone
 * @property string|null                                               $email
 * @property bool                                                      $checked_type_fond
 * @property-read ?Address                                              $address
 * @property-read \Illuminate\Database\Eloquent\Collection<Attribute>|Attribute[] $attrs
 * @property-read int|null                                             $attrs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<Category>|Category[]  $categories
 * @property-read int|null                                             $categories_count
 * @property-read mixed                                                $costs
 * @property-read mixed                                                $meta_description
 * @property-read mixed                                                $meta_keywords
 * @property-read mixed                                                $meta_title
 * @property-read \Domain\Image\Models\Image                                                $image
 * @property-read \Illuminate\Database\Eloquent\Collection<\Domain\Image\Models\Image>|\Domain\Image\Models\Image[]     $images
 * @property-read int|null                                             $images_count
 * @property-read PageDescription                                      $meta
 * @property-read \Illuminate\Database\Eloquent\Collection<\Domain\Address\Models\Metro>|\Domain\Address\Models\Metro[]     $metros
 * @property-read int|null                                             $metros_count
 * @property-read \Illuminate\Database\Eloquent\Collection<Rating>|Rating[]    $ratings
 * @property-read int|null                                             $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<Review>|Review[]    $reviews
 * @property-read int|null                                             $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<Room>|\Domain\Room\Models\Room[]      $rooms
 * @property-read int|null                                             $rooms_count
 * @property-read HotelType|null                                       $type
 * @property-read User                                                 $user
 * @property-read mixed                                                $disabled_save
 * @property-read \Illuminate\Database\Eloquent\Collection<User>|User[]      $users
 * @property-read int|null                                             $users_count
 * @property-read string|null                                          $meta_h1
 * @property-read SeoData                                              $seo_data
 *
 * @method static Builder|Hotel newModelQuery()
 * @method static Builder|Hotel newQuery()
 * @method static Builder|Hotel popular()
 * @method static Builder|Hotel query()
 * @method static Builder|Hotel whereCreatedAt($value)
 * @method static Builder|Hotel whereDescription($value)
 * @method static Builder|Hotel whereEmail($value)
 * @method static Builder|Hotel whereHidePhone($value)
 * @method static Builder|Hotel whereId($value)
 * @method static Builder|Hotel whereIsPopular($value)
 * @method static Builder|Hotel whereModerate($value)
 * @method static Builder|Hotel whereName($value)
 * @method static Builder|Hotel whereOldModerate($value)
 * @method static Builder|Hotel wherePhone($value)
 * @method static Builder|Hotel wherePhone2($value)
 * @method static Builder|Hotel whereRoute($value)
 * @method static Builder|Hotel whereRouteTitle($value)
 * @method static Builder|Hotel whereShow($value)
 * @method static Builder|Hotel whereSlug($value)
 * @method static Builder|Hotel whereTypeFond($value)
 * @method static Builder|Hotel whereTypeId($value)
 * @method static Builder|Hotel whereUpdatedAt($value)
 * @method static Builder|Hotel whereUserId($value)
 * @method static Builder|Hotel whereCheckedTypeFond($value)
 * @method HotelData getData()
 */
final class Hotel extends Model
{
    use UseImages;
    use ClearValidated;
    use CreatedAtOrdered;
    use HasFactory;
    use WithData;

    protected string $dataClass = HotelData::class;

    /**
     * Page
     *
     * @var int
     */
    public const PER_PAGE = 6;

    /**
     * Many rooms have one category
     *
     * @var string
     */
    public const ROOMS_TYPE = 'rooms';

    /**
     * Room has one category in hotel
     *
     * @var string
     */
    public const CATEGORIES_TYPE = 'categories';

    /**
     * Types Rooms in Hotel
     *
     * @var string[]
     */
    public const TYPES_FOND = [
        self::ROOMS_TYPE,
        self::CATEGORIES_TYPE,
    ];

    protected $fillable = [
        'name',
        'description',
        'phone',
        'phone_2',
        'route_title',
        'route',
        'is_popular',
        'user_id',
        'hide_phone',
        'email',
        'type_fond',
        'save_columns',
        'old_moderate',
        'moderate',
        'show',
        'checked_type_fond',
        'slug',
    ];

    protected $hidden = ['email'];

    /**
     * The relations to eager load on every query.
     *
     * @var string[]
     */
    protected $with = ['rooms', 'attrs', 'address', 'ratings', 'reviews', 'metros', 'images', 'image', 'type'];

    protected $casts = [
        'moderate' => 'boolean',
        'old_moderate' => 'boolean',
        'show' => 'boolean',
        'checked_type_fond' => 'boolean',
        'phone' => PhoneNumberCast::class,
        'created_at' => 'datetime:Y-m-d\TH:i:sP',
        'updated_at' => 'datetime:Y-m-d\TH:i:sP',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        //static::addGlobalScope(new ModerationScope);
    }

    /**
     * Hotel has user (staff, general)
     *
     * @return BelongsToMany
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(
            \Domain\Attribute\Model\Attribute::class,
            'attribute_hotel',
            'hotel_id',
            'attribute_id'
        );
    }

    /**
     * Categories in Hotel
     *
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this
            ->hasMany(Category::class)
            ->orderBy('created_at');
    }

    /**
     * Hotel Type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(HotelType::class);
    }

    public function reviews(): HasMany
    {
        return $this
            ->hasMany(Review::class)
            ->with('ratings');
    }

    public function ratings(): HasManyThrough
    {
        return $this->hasManyThrough(Rating::class, Review::class);
    }

    /**
     * Metro in Hotel
     *
     * @return HasMany
     */
    public function metros(): HasMany
    {
        return $this->hasMany(\Domain\Address\Models\Metro::class);
    }

    /**
     * Meta_Description
     *
     * @return string
     */
    public function getMetaDescriptionAttribute(): string
    {
        $result = $this->meta->meta_description ?? $this->seo_data->description;
        if (! $result) {
            return '';
        }

        return $result;
    }

    /**
     * Meta_Keywords
     *
     * @return string|null
     */
    public function getMetaKeywordsAttribute(): ?string
    {
        return $this->meta->meta_keywords ?? null;
    }

    /**
     * Meta_Title
     *
     * @return string|null
     */
    public function getMetaTitleAttribute(): ?string
    {
        return $this->meta->title ?? $this->seo_data->title;
    }

    /**
     * Meta_H1
     *
     * @return string|null
     */
    public function getMetaH1Attribute(): ?string
    {
        return $this->meta->h1 ?? $this->seo_data->h1;
    }

    /**
     * Generate seo data if PageDescription of Null
     *
     * @return SeoData
     */
    public function getSeoDataAttribute(): SeoData
    {
        $url = '/hotels/'.$this->slug;
        $seoData = SeoData::fromAddressAndUrlHotel($url, $this, $this->address);

        return GenerateSeoDataContent::run($seoData);
    }

    /**
     * All costs in all rooms
     *
     * @return Collection
     */
    public function getCostsAttribute(): Collection
    {
        return $this->rooms()->with('costs.period')->get()->pluck('costs')->flatten();
    }

    /**
     * Room in Hotel
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(\Domain\Room\Models\Room::class)->orderBy('order', 'ASC');
    }

    public function saveAddress(string $address_raw, ?string $comment = null): void
    {
        SaveHotelAddress::run($this, $address_raw, $comment);
    }

    /**
     * Address
     *
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function attachMeta(PageDescriptionData $data): Hotel
    {
        $meta = PageDescription::updateOrCreate(['url' => $data->url], $data->toArray());

        $this->meta()->save($meta);

        return $this;
    }

    /**
     * PageDescription | SEO
     *
     * @return HasOne
     */
    public function meta(): HasOne
    {
        return $this
            ->hasOne(PageDescription::class, 'model_id')
            ->where('model_type', self::class);
    }

    public function getMinimalsAttribute(): object
    {
        return $this->getMinCosts();
    }

    /**
     * Minimal costs in type for all rooms
     *
     * @return DataCollection<(int|string), MinCostsData>
     */
    public function getMinCosts(): DataCollection
    {
        return MinimumCostsCalculation::run($this);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * if lk user, create room, always disable button in form save.
     * Not admin and moderator
     *
     * @return string
     */
    public function getDisabledSaveAttribute(): string
    {
        if (! $this->old_moderate) {
            return '';
        }

        return 'disabled';
    }

    /**
     * Generate Unique slug
     *
     * @return string
     */
    public function generateSlug(): string
    {
        return GenerateSlugForHotel::run($this->getData());
    }

    public static function newFactory(): HotelFactory
    {
        return HotelFactory::new();
    }

    /**
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return HotelBuilder<Hotel>
     */
    public function newEloquentBuilder($query): HotelBuilder
    {
        return new HotelBuilder($query);
    }
}
