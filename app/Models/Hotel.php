<?php

namespace App\Models;

use App\Traits\ClearValidated;
use App\Traits\CreatedAtOrdered;
use App\Traits\UseImages;
use App\User;
use Exception;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;

class Hotel extends Model
{
  use UseImages;
  use ClearValidated;
  use CreatedAtOrdered;

  public const PER_PAGE = 6;

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
    'moderate'
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
    'save_columns' => 'object'
  ];

  public const ROOMS_TYPE = 'rooms';
  public const CATEGORIES_TYPE = 'categories';

  public const TYPES_FOND = [
    self::ROOMS_TYPE,
    self::CATEGORIES_TYPE
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

  public function rooms(): HasMany
  {
    return $this->hasMany(Room::class)->orderBy('created_at');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
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
  ### END RELATIONS

  ### MUTATORS

  public function getMetaDescriptionAttribute(): string
  {
    return @$this->meta->meta_description ?? $this->getDescDefault();
  }

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

  public function checkSaved ($attributes): bool
  {
    if (!isset($this->save_columns->columns)) {
      $this->save_columns = (object) ['columns' => []];
      $this->save();
      return false;
    }
    $flag = true;
    foreach ($attributes as $key) {
      if (!in_array($key, $this->save_columns->columns, true)) {
        $flag = false;
      }
    }

    return $flag;
  }

  public function updateFillable (): void
  {
    $arr = $this->getFillable();
//    $arr = array_diff_assoc($arr, $this->save_columns->columns);
    $arr = array_filter($arr,fn($key) => !in_array($key,$this->save_columns->columns,ARRAY_FILTER_USE_KEY));
    $this->fillable($arr);
  }
  ### END OVERWRITES
}
