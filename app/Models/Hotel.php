<?php

namespace App\Models;

use App\Traits\ClearValidated;
use App\Traits\CreatedAtOrdered;
use App\Traits\UseImages;
use App\User;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Hotel extends Model
{
    use UseImages;
    use ClearValidated;
    use CreatedAtOrdered;

    const PER_PAGE = 6;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'route_title',
        'route',
        'is_popular',
        'user_id',
        'hide_phone',
        'email',
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
        'costs',
        'image',
        'type'
    ];

    ### SCOPES
    public function scopePopular(Builder $query): Builder
    {
        return $query->where('is_popular', true);
    }
    ### END SCOPES

    ### RELATIONS
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

    public function costs(): MorphMany
    {
        return $this->morphMany(Cost::class, 'model');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(HotelType::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->with('ratings');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function ratings(): HasManyThrough
    {
        return $this->hasManyThrough(Rating::class, Review::class);
    }

    public function metros(): HasMany
    {
        return $this->hasMany(Metro::class);
    }

    public function meta(): HasOne
    {
        return $this->hasOne(PageDescription::class, 'model_id')->where('model_type', self::class);
    }
    ### END RELATIONS

    ### MUTATORS
    public function getPhoneAttribute($value)
    {
        if (!$this->hide_phone && !\Request::is('admin/*'))
            $value = null;
        return $value;
    }

    public function getMetaDescriptionAttribute()
    {
        return @$this->meta->meta_description ?? $this->getDescDefault();
    }

    public function getMetaKeywordsAttribute()
    {
        return @$this->meta->meta_keywords ?? null;
    }

    public function getMetaTitleAttribute()
    {
        return @$this->meta->title ?? $this->getTitleDefault();
    }

    ### END MUTATORS

    ### FUNCTIONS

    public function getAddressInfo(string $address): array
    {
        $suggest = DadataSuggest::suggest('address', ['query' => $address, 'count' => 1]);
        $suggest['data']['value'] = $suggest['value'];
        return Address::getFillableData($suggest['data']);
    }

    public function saveAddress(string $address_raw, $comment = null): void
    {
        $address = $this->getAddressInfo($address_raw);
        $address['comment'] = empty($comment) ? null : $comment;
        $this->address()->delete();
        $this->address()->create($address)->save();
        $this->save();
    }

    public function getMinCosts()
    {
        $costs = Cache::remember('hotel.'.$this->id.'.costs', 60*60*24*12, function() {
            $rooms = $this->rooms->pluck('id')->toArray();
            $costs = [];
            foreach ($this->costs->sortBy('type.sort') AS $cost) {
                $type_id = $cost->type->id;
                $min_in_rooms = Cache::remember('rooms.costs.'.$type_id.'.'.implode('-', $rooms), 60*60*24*12, function() use($rooms, $type_id) {
                    return Cost::where('model_type', Room::class)
                        ->whereIn('model_id', $rooms)
                        ->where('type_id', $type_id)
                        ->where('value', '>', 0)
                        ->min('value') ?? '0';
                });
                $costs[] = [
                    'name' => $cost->type->name,
                    'id' => $cost->type->id,
                    'description' => $cost->description,
                    'value' => $min_in_rooms,
                ];
            }
            return $costs;
        });

        return (object) $costs;
    }

    private function getTitleDefault()
    {
        $street = optional($this->address)->street;
        $area_short = optional($this->address)->city_area_short;
        $metro = optional(optional($this->metros)->first())->name;
        return "Отель {$this->name}, {$street}, в {$area_short}, у метро {$metro}";
    }

    private function getDescDefault()
    {
        $desc = "%s %s %sв г. %s: большая база почасовых отелей с описанием номеров. Сортировка по районам, метро, округам и стоимости и скидки на проживание!";
        $costs = (array) $this->getMinCosts();

        if (current($costs)) {
            $cost = current($costs);
            $cost = "по цене " . $cost['value'] . " руб. на час ";
        } else {
            $cost = "";
        }

        return sprintf($desc, $this->name, optional($this->address)->street, $cost, optional($this->address)->city ?? 'Москва');
    }

    public function attachMeta(Request $request): Hotel
    {
        if (!$request->get('meta_title', false) && !$request->get('meta_description', false) && !$request->get('meta_keywords', false))
            return $this;

        $url = '/hotels/'.$this->slug;

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

    protected static function boot()
    {
        parent::boot();

        self::creating(function(Hotel $hotel) {
            $hotel->slug = $hotel->slug ?? Str::slug($hotel->name);
            Cache::forget('sitemap.2g');
        });

        self::created(function(Hotel $hotel) {
            try {
                if (!PageDescription::where('url', '/address/' . Str::slug($hotel->address->city))->exists()) {
                    $pageDesc = new PageDescription();
                    $pageDesc->url = '/address/' . Str::slug($hotel->address->city);
                    $pageDesc->title = 'Отели города "' . $hotel->address->city . '"';
                    $pageDesc->save();
                }
            } catch (\Exception $exception) {
                Log::error($exception);
            }
        });

        self::updated(function(Hotel $hotel) {
            try {
                if (!PageDescription::where('url', '/address/' . Str::slug($hotel->address->city))->exists()) {
                    $pageDesc = new PageDescription();
                    $pageDesc->url = '/address/' . Str::slug($hotel->address->city);
                    $pageDesc->title = 'Отели города "' . $hotel->address->city . '"';
                    $pageDesc->save();
                }
            } catch (\Exception $exception) {
                Log::error($exception);
            }
        });
        self::updating(function(self $hotel) {
            Cache::forget('sitemap.2g');
        });
        self::deleting(function(self $hotel) {
            Cache::forget('sitemap.2g');
        });
    }
    ### END OVERWRITES
}
