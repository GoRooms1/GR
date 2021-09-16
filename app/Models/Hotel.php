<?php

namespace App\Models;

use App\User;
use Eloquent;
use Exception;
use App\Traits\UseImages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ClearValidated;
use Illuminate\Support\Carbon;
use App\Traits\CreatedAtOrdered;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
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
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $phone
 * @property string|null $phone_2
 * @property string $type_fond
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_popular
 * @property int|null $type_id
 * @property string|null $route
 * @property bool $old_moderate
 * @property bool $show
 * @property bool $moderate
 * @property string $route_title
 * @property string|null $slug
 * @property int $hide_phone
 * @property string|null $email
 * @property-read Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|Attribute[] $attrs
 * @property-read int|null $attrs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read mixed $costs
 * @property-read mixed $meta_description
 * @property-read mixed $meta_keywords
 * @property-read mixed $meta_title
 * @property-read Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read PageDescription $meta
 * @property-read \Illuminate\Database\Eloquent\Collection|Metro[] $metros
 * @property-read int|null $metros_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Room[] $rooms
 * @property-read int|null $rooms_count
 * @property-read HotelType|null $type
 * @property-read User $user
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
 * @mixin Eloquent
 * @property bool $checked_type_fond
 * @method static Builder|Hotel whereCheckedTypeFond($value)
 */
class Hotel extends Model
{
  use UseImages;
  use ClearValidated;
  use CreatedAtOrdered;

  public const PER_PAGE = 6;
  public const ROOMS_TYPE = 'rooms';
  public const CATEGORIES_TYPE = 'categories';
  public const TYPES_FOND = [
    self::ROOMS_TYPE,
    self::CATEGORIES_TYPE
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
    'checked_type_fond'
  ];
  protected $hidden = [
    'email',
  ];
  protected $with = [
    'rooms',
    'attrs',
    'address',
    'ratings',
    'reviews',
    'metros',
    'images',
    'image',
    'type'
  ];
  protected $casts = [
    'moderate' => 'boolean',
    'old_moderate' => 'boolean',
    'show' => 'boolean',
    'checked_type_fond' => 'boolean'
  ];

  ### SCOPES

  protected static function boot()
  {
    parent::boot();

//    TODO: Moderate Scope
//    static::addGlobalScope('moderation', function (Builder $builder) {
//      if (auth()->check()) {
//        if (!auth()->user()->is_admin && !auth()->user()->is_moderate) {
//          $builder->where('moderate', '=', false);
//        }
//      } else {
//        $builder->where('moderate', '=', false);
//      }
//    });

    self::creating(function (Hotel $hotel) {
      $hotel->slug = $hotel->slug ?? Str::slug($hotel->name);
      Cache::forget('sitemap.2g');
    });

    self::created(function (Hotel $hotel) {
      try {
        if (!PageDescription::where('url', '/address/' . Str::slug($hotel->address->city))->exists()) {
          $pageDesc = new PageDescription();
          $pageDesc->url = '/address/' . Str::slug($hotel->address->city);
          $pageDesc->title = 'Отели города "' . $hotel->address->city . '"';
          $pageDesc->save();
        }
      } catch (Exception $exception) {
        Log::error($exception);
      }
    });

    self::updated(function (Hotel $hotel) {
      try {
        if (!PageDescription::where('url', '/address/' . Str::slug($hotel->address->city))->exists()) {
          $pageDesc = new PageDescription();
          $pageDesc->url = '/address/' . Str::slug($hotel->address->city);
          $pageDesc->title = 'Отели города "' . $hotel->address->city . '"';
          $pageDesc->save();
        }
      } catch (Exception $exception) {
        Log::error($exception);
      }
    });
    self::updating(function (self $hotel) {
      Cache::forget('sitemap.2g');
    });
    self::deleting(function (self $hotel) {
      Cache::forget('sitemap.2g');
    });
  }
  ### END SCOPES

  ### RELATIONS

  public function scopePopular(Builder $query): Builder
  {
    return $query->where('is_popular', true);
  }

  public function users(): belongsToMany
  {
    return $this->belongsToMany(User::class);
  }

  public function attrs(): BelongsToMany
  {
    return $this->belongsToMany(Attribute::class, 'attribute_hotel', 'hotel_id', 'attribute_id');
  }

  public function categories(): HasMany
  {
    return $this->hasMany(Category::class)->orderBy('created_at');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo(HotelType::class);
  }

  public function reviews(): HasMany
  {
    return $this->hasMany(Review::class)->with('ratings');
  }

  public function ratings(): HasManyThrough
  {
    return $this->hasManyThrough(Rating::class, Review::class);
  }

  public function metros(): HasMany
  {
    return $this->hasMany(Metro::class);
  }

  public function getPhoneAttribute($value)
  {
    if (!$this->hide_phone && !\Request::is('admin/*') && !\Request::is('lk/*')) {
      $value = null;
    }
    return $value;
  }

  public function getMetaDescriptionAttribute(): string
  {
    return @$this->meta->meta_description ?? $this->getDescDefault();
  }
  ### END RELATIONS

  ### MUTATORS

  private function getDescDefault(): string
  {
    $desc = "%s %s %sв г. %s: большая база почасовых отелей с описанием номеров. Сортировка по районам, метро, округам и стоимости и скидки на проживание!";
    $costs = (array)$this->getMinCosts();

    if (current($costs)) {
      $cost = current($costs);
      $cost = "по цене " . $cost['value'] . " руб. на час ";
    } else {
      $cost = "";
    }

    return sprintf($desc, $this->name, optional($this->address)->street, $cost, optional($this->address)->city ?? 'Москва');
  }

  public function getMinCosts()
  {
    $costs = Cache::remember('hotel.' . $this->id . '.costs', 60 * 60 * 24 * 12, function () {
      $rooms = $this->rooms->pluck('id')->toArray();
      $costs = [];
      $types = [];
      foreach ($this->costs->sortBy('period.type.sort') as $cost) {
        $type_id = $cost->period->type->id;
        if (!in_array($type_id, $types)) {
          $types[] = $type_id;
          $min_in_rooms = Cache::remember('rooms.costs.' . $type_id . '.' . implode('-', $rooms), 60 * 60 * 24 * 12, function () use ($rooms, $type_id) {
            return Cost::whereIn('room_id', $rooms)
                ->whereHas('period', function ($q) use ($type_id) {
                  $q->where('cost_type_id', $type_id);
                })
                ->where('value', '>', 0)
                ->min('value') ?? '0';
          });
          $costs[] = [
            'name' => $cost->period->type->name,
            'id' => $cost->period->type->id,
            'description' => $cost->description,
            'info' => $cost->period->info,
            'value' => $min_in_rooms,
          ];
        }
      }
      return $costs;
    });

    return (object)$costs;
  }

  public function getCostsAttribute(): Collection
  {
    return $this->rooms()->get()->pluck('costs')->flatten();
  }

  public function rooms(): HasMany
  {
    return $this->hasMany(Room::class)->orderBy('created_at');
  }

  public function getMetaKeywordsAttribute()
  {
    return @$this->meta->meta_keywords ?? null;
  }

  ### END MUTATORS

  ### FUNCTIONS

  public function getMetaTitleAttribute()
  {
    return @$this->meta->title ?? $this->getTitleDefault();
  }

  private function getTitleDefault()
  {
    $street = optional($this->address)->street;
    $area_short = optional($this->address)->city_area_short;
    $metro = optional(optional($this->metros)->first())->name;
    return "Отель {$this->name}, {$street}, в {$area_short}, у метро {$metro}";
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

  public function address(): HasOne
  {
    return $this->hasOne(Address::class);
  }

  public function attachMeta(Request $request): Hotel
  {
    if (!$request->get('meta_title', false) && !$request->get('meta_description', false) && !$request->get('meta_keywords', false))
      return $this;

    $url = '/hotels/' . $this->slug;

    $data = [];

    $title = $this->getTitleDefault();
    $meta_desc = $this->getDescDefault();

    $data['title'] = $request->get('meta_title', $title);
    $data['meta_description'] = $request->get('meta_description', $meta_desc);
    $data['meta_keywords'] = $request->get('meta_keywords');
    $data['url'] = $url;
    $data['model_type'] = self::class;

    $meta = PageDescription::updateOrCreate(['url' => $url], $data);
    $meta->model_type = self::class;
    $meta->save();

    $this->meta()->save($meta);

    return $this;
  }

  ### END FUNCTIONS

  ### OVERWRITES

  public function meta(): HasOne
  {
    return $this->hasOne(PageDescription::class, 'model_id')->where('model_type', self::class);
  }

  public function __get($key)
  {
    if ($key === 'minimals')
      return $this->getMinCosts();
    return parent::__get($key); // TODO: Change the autogenerated stub
  }

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function getDisabledSaveAttribute(): string
  {
    return $this->old_moderate ? 'disabled' : '';
  }

  ### END OVERWRITES
}
