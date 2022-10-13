<?php

namespace App\Models;

use App\User;
use Eloquent;
use App\Helpers\SeoData;
use App\Traits\UseImages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ClearValidated;
use Illuminate\Support\Carbon;
use App\Traits\CreatedAtOrdered;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * App\Models\Hotel
 *
 * @property int                                                       $id
 * @property string                                                    $name
 * @property string|null                                               $description
 * @property string                                                    $phone
 * @property string|null                                               $phone_2
 * @property string                                                    $type_fond
 * @property int                                                       $user_id
 * @property Carbon|null                                               $created_at
 * @property Carbon|null                                               $updated_at
 * @property int                                                       $is_popular
 * @property int|null                                                  $type_id
 * @property string|null                                               $route
 * @property bool                                                      $old_moderate
 * @property bool                                                      $show
 * @property bool                                                      $moderate
 * @property string                                                    $route_title
 * @property string|null                                               $slug
 * @property int                                                       $hide_phone
 * @property string|null                                               $email
 * @property bool                                                      $checked_type_fond
 * @property-read Address                                              $address
 * @property-read \Illuminate\Database\Eloquent\Collection|Attribute[] $attrs
 * @property-read int|null                                             $attrs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[]  $categories
 * @property-read int|null                                             $categories_count
 * @property-read mixed                                                $costs
 * @property-read mixed                                                $meta_description
 * @property-read mixed                                                $meta_keywords
 * @property-read mixed                                                $meta_title
 * @property-read Image                                                $image
 * @property-read \Illuminate\Database\Eloquent\Collection|Image[]     $images
 * @property-read int|null                                             $images_count
 * @property-read PageDescription                                      $meta
 * @property-read \Illuminate\Database\Eloquent\Collection|Metro[]     $metros
 * @property-read int|null                                             $metros_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Rating[]    $ratings
 * @property-read int|null                                             $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Review[]    $reviews
 * @property-read int|null                                             $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Room[]      $rooms
 * @property-read int|null                                             $rooms_count
 * @property-read HotelType|null                                       $type
 * @property-read User                                                 $user
 * @property-read mixed                                                $disabled_save
 * @property-read \Illuminate\Database\Eloquent\Collection|User[]      $users
 * @property-read int|null                                             $users_count
 * @property-read string|null                                          $meta_h1
 * @property-read SeoData                                              $seo_data
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
 * @mixin Eloquent
 */
class Hotel extends Model
{

  use UseImages;
  use ClearValidated;
  use CreatedAtOrdered;

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
   * @var array
   */
  public const TYPES_FOND = [
    self::ROOMS_TYPE,
    self::CATEGORIES_TYPE,
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
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
    'slug'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array
   */
  protected $hidden = ['email'];

  /**
   * The relations to eager load on every query.
   *
   * @var array
   */
  protected $with = ['rooms', 'attrs', 'address', 'ratings', 'reviews', 'metros', 'images', 'image', 'type'];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'moderate' => 'boolean',
    'old_moderate' => 'boolean',
    'show' => 'boolean',
    'checked_type_fond' => 'boolean',
  ];

  /**
   * Bootstrap the model and its traits.
   *
   * @return void
   */
  protected static function boot(): void
  {
    parent::boot();

    static::addGlobalScope('moderation', static function (Builder $builder) {

      if (auth()->check()) {
        if (Route::currentRouteNamed('lk.*')) {
          // Some stop if
        } else if ((!auth()->user()->is_admin && !auth()->user()->is_moderate) &&
          !Route::currentRouteNamed('lk.*') &&
          !Route::currentRouteNamed('moderator.*') &&
          !Route::currentRouteNamed('api.*') &&
          !Route::currentRouteNamed('admin.*')
        ) {
//          Если залогинен значит выводим только проверенные отели в которых есть комнаты
          $builder
            ->withCount(['rooms' => function ($query) {
              $query->withoutGlobalScope('moderation')->where('moderate', false);
            }])
            ->having('rooms_count', '>', 0)
            ->where('moderate', false)
            ->where('old_moderate', true)
            ->where('show', true);
        } else if (
          (auth()->user()->is_moderate || auth()->user()->is_admin) &&
          !Route::currentRouteNamed('admin.*') &&
          !Route::currentRouteNamed('moderator.*')
        ) {
//          Если модератор то показываем отели только те которые уже заполнили и создавали ранее комнату
          $builder
            ->where('old_moderate', true);
        }
//        Если залогинен н админ то выводим просто всё
      } else {
//        Если не залогинен значит выводим только проверенные отели в которых есть комнаты
        $builder->withCount(['rooms' => function ($query) {
          $query->withoutGlobalScope('moderation')->where('moderate', false);
        }])
          ->where('moderate', false)
          ->where('show', true)
          ->where('old_moderate', true)
          ->having('rooms_count', '>', 0);
      }
    });

  }


  public function scopePopular(Builder $query): Builder
  {
    return $query->where('is_popular', true);
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
      Attribute::class,
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
    return $this->hasMany(Metro::class);
  }

  /**
   * If admin or moderator view phone
   *
   * @param $value
   *
   * @return string|null
   */
  public function getPhoneAttribute($value): ?string
  {
    if (!$this->hide_phone && !\Request::is('admin/*') && !\Request::is('lk/*') && !\Request::is('moderator/*')) {
      $value = null;
    }

    return $value;
  }

  /**
   * Meta_Description
   *
   * @return string
   */
  public function getMetaDescriptionAttribute(): string
  {
    return $this->meta->meta_description ?? $this->seo_data->description;
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
    $url = '/hotels/' . $this->slug;
    $seoData = new SeoData($this->address, $url);
    $seoData->lastOfType = 'hotel';
    $seoData->hotel = $this;
    $seoData->generate();

    return $seoData;
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
    return $this->hasMany(Room::class)->orderBy('order', 'ASC');
  }

  public function saveAddress(string $address_raw, $comment = null): void
  {
    $address = $this->getAddressInfo($address_raw);
    $address['comment'] = empty($comment) ? null : $comment;
    $this->address()->delete();
    $this->address()->create($address)->save();
    $this->save();
  }

  public function getAddressInfo(string $address): array
  {
    $suggest = DadataSuggest::suggest('address', ['query' => $address, 'count' => 1]);
    $suggest['data']['value'] = $suggest['value'];

    return Address::getFillableData($suggest['data']);
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

  public function attachMeta(Request $request): Hotel
  {
    if (!$request->get('meta_title', false) && !$request->get('meta_description', false) && !$request->get('meta_keywords', false)) return $this;

    $url = '/hotels/' . $this->slug;

    $data = [];

    $data['title'] = $request->get('meta_title', $this->meta_title);
    $data['meta_description'] = $request->get('meta_description', $this->meta_description);

    $data['meta_keywords'] = $request->get('meta_keywords');
    $data['h1'] = $request->get('h1', $this->meta_h1);
    $data['url'] = $url;
    $data['model_type'] = self::class;

    $meta = PageDescription::updateOrCreate(['url' => $url], $data);
    $meta->model_type = self::class;
    $meta->save();

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

  /**
   * Dynamically retrieve attributes on the model.
   *
   * @param string $key
   *
   * @return mixed
   */
  public function __get($key)
  {
    if ($key === 'minimals') {
      return $this->getMinCosts();
    }

    return parent::__get($key);
  }

  /**
   * Minimal costs in type for all rooms
   *
   * @return object
   */
  public function getMinCosts(): object
  {;
    $costs = Cache::remember('hotel.' . $this->id . '.costs', 60 * 60 * 24 * 12, function () {
      $rooms = $this->rooms->pluck('id')->toArray();
      $items = new Collection();
      $types = [];
      foreach ($this->costs->sortBy('period.type.sort') as $cost) {
        $type_id = $cost->period->type->id;
        if (!in_array($type_id, $types, true)) {
          $types[] = $type_id;
          $min_in_rooms = Cache::remember('rooms.costs.' . $type_id . '.' . implode('-', $rooms), 60 * 60 * 24 * 12, function () use ($rooms, $type_id) {
            return Cost::whereIn('room_id', $rooms)->whereHas('period', function ($q) use ($type_id) {
                $q->where('cost_type_id', $type_id);
              })->where('value', '>', 0)->min('value') ?? '0';
          });

          $costPeriod = $this->costs->where('value', $min_in_rooms)->where('period.cost_type_id', $type_id)->first();
          $cost = $costPeriod ?? $cost;

          $item = (object)['name' => $cost->period->type->name, 'id' => $cost->period->type->id, 'description' => $cost->description, 'info' => $cost->period->info, 'value' => $min_in_rooms,];
          $items->add($item);
        }
      }

      $types = CostType::orderBy('sort')->get();
      $costs = new Collection();
      foreach ($types as $type) {
        $check = $items->contains('id', $type->id);
        if (!$check) {
          $costs->add((object)[
            'name' => $type->name,
            'info' => 'Не предоставляется',
            'value' => 0,
          ]);
        } else {
          $costs->add($items->firstWhere('id', '=', $type->id));
        }
      }

      return $costs;
    });

    return (object)$costs;
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
    if (!$this->old_moderate) {
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
    $i = 0;
    do {
      $slug = Str::slug($this->name) . ($i > 0 ? '-' . $i : '');
      $i++;
    } while (self::withoutGlobalScope('moderation')->whereSlug($slug)->exists());

    return $slug;
  }
}
