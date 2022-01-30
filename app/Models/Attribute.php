<?php

namespace App\Models;

use App\Traits\CreatedAtOrdered;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Attribute
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $model
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property boolean $in_filter
 * @property int $attribute_category_id
 * @property-read mixed $category
 * @property-read mixed $model_name
 * @method static Builder|Attribute filtered()
 * @method static Builder|Attribute forHotels()
 * @method static Builder|Attribute forRooms()
 * @method static Builder|Attribute newModelQuery()
 * @method static Builder|Attribute newQuery()
 * @method static Builder|Attribute query()
 * @method static Builder|Attribute whereAttributeCategoryId($value)
 * @method static Builder|Attribute whereCreatedAt($value)
 * @method static Builder|Attribute whereDescription($value)
 * @method static Builder|Attribute whereId($value)
 * @method static Builder|Attribute whereInFilter($value)
 * @method static Builder|Attribute whereModel($value)
 * @method static Builder|Attribute whereName($value)
 * @method static Builder|Attribute whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Attribute extends Model
{
  use CreatedAtOrdered;

  public const MODELS_TRANSLATE = [
    Hotel::class => 'Отели',
    Room::class => 'Номера',
  ];

  protected $fillable = [
    'name',
    'description',
    'model',
    'in_filter'
  ];

  protected $casts = [
    'in_filter' => 'boolean'
  ];

  public function scopeForHotels(Builder $builder): Builder
  {
    return $builder->where('model', Hotel::class);
  }

  public function scopeForRooms(Builder $builder): Builder
  {
    return $builder->where('model', Room::class);
  }

  public function scopeFiltered(Builder $builder): Builder
  {
    return $builder->where('in_filter', true);
  }

  public function getCategoryAttribute()
  {
    $model = explode('\\', $this->getModelNameAttribute());
    $model = end($model);
    $model = mb_strtolower($model);
    return $model;
  }

  public function getModelNameAttribute()
  {
    return $this->getAttributes()['model'];
  }

  public function relationCategory ()
  {
    return $this->belongsTo(AttributeCategory::class, 'attribute_category_id', 'id');
  }
}
