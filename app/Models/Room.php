<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use App\Traits\UseImages;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property int $moderate
 * @property string|null $description
 * @property int $hotel_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $category_id
 * @property int $is_hot
 * @property-read Collection|Attribute[] $attrs
 * @property-read int|null $attrs_count
 * @property-read Category|null $category
 * @property-read Collection|Cost[] $costs
 * @property-read int|null $costs_count
 * @property-read mixed $meta_description
 * @property-read mixed $meta_keywords
 * @property-read mixed $meta_title
 * @property-read Hotel $hotel
 * @property-read Image $image
 * @property-read Collection|Image[] $images
 * @property-read int|null $images_count
 * @property-read PageDescription $meta
 * @method static bool|null forceDelete()
 * @method static Builder|Room hot()
 * @method static Builder|Room newModelQuery()
 * @method static Builder|Room newQuery()
 * @method static \Illuminate\Database\Query\Builder|Room onlyTrashed()
 * @method static Builder|Room query()
 * @method static bool|null restore()
 * @method static Builder|Room whereCategoryId($value)
 * @method static Builder|Room whereCreatedAt($value)
 * @method static Builder|Room whereDeletedAt($value)
 * @method static Builder|Room whereDescription($value)
 * @method static Builder|Room whereHotelId($value)
 * @method static Builder|Room whereId($value)
 * @method static Builder|Room whereIsHot($value)
 * @method static Builder|Room whereModerate($value)
 * @method static Builder|Room whereName($value)
 * @method static Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Room withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Room withoutTrashed()
 * @mixin Eloquent
 */
class Room extends Model
{
  use SoftDeletes;
  use UseImages;
  use CreatedAtOrdered;

  public const PER_PAGE = 6;

  public string $no_image = 'img/img-room-sm-1.jpg';

  protected $with = [
    'attrs',
    'images',
    'costs',
  ];

  ### SCOPES

  protected static function boot()
  {
    parent::boot();

//    static::addGlobalScope('moderation', function (Builder $builder) {
//      if (auth()->check()) {
//        if (!auth()->user()->is_admin && !auth()->user()->is_moderate) {
//          $builder->whereHas('hotel', function ($q) {
//            $q->where('moderate', '=', false);
//          })->where('moderate', '=', false);
//        }
//      } else {
//         $builder->whereHas('hotel', function ($q) {
//            $q->where('moderate', '=', false);
//          })->where('moderate', '=', false);
//      }
//    });
  }

  public function hotel(): BelongsTo
  {
    return $this->belongsTo(Hotel::class);
  }

  public function attrs(): BelongsToMany
  {
    return $this->belongsToMany(Attribute::class, 'attribute_room', 'room_id', 'attribute_id');
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function scopeHot(Builder $query): Builder
  {
    return $query->where('is_hot', true);
  }

  public function costs(): HasMany
  {
    return $this->hasMany(Cost::class, 'room_id', 'id');
  }

  public function attachMeta(Request $request): Room
  {
    if (!$request->get('meta_title', false) && !$request->get('meta_description', false) && !$request->get('meta_keywords', false))
      return $this;

    $key = $this->getRouteKeyName();
    $url = '/rooms/' . $this->$key;

    $data = [];
    $data['title'] = $request->get('meta_title');
    $data['meta_description'] = $request->get('meta_description');
    $data['meta_keywords'] = $request->get('meta_keywords');
    $data['url'] = $url;
    $data['model_type'] = self::class;

    $meta = PageDescription::updateOrCreate(['url' => $url], $data);
    $meta->model_type = self::class;
    $meta->save();

    $this->meta()->save($meta);

    return $this;
  }

  public function meta(): HasOne
  {
    return $this->hasOne(PageDescription::class, 'model_id')->where('model_type', self::class);
  }

  public function getMetaDescriptionAttribute()
  {
    return @$this->meta->meta_description ?? null;
  }

  public function getMetaKeywordsAttribute()
  {
    return @$this->meta->meta_keywords ?? null;
  }

  public function getMetaTitleAttribute()
  {
    return @$this->meta->title ?? null;
  }
}
