<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Тип для стоимости (На день на ночь и тп)
 *
 * @property int                      $id
 * @property string                   $name
 * @property int                      $sort
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property string|null              $description
 * @property-read Collection|Period[] $periods
 * @property-read int|null            $periods_count
 * @method static Builder|CostType newModelQuery()
 * @method static Builder|CostType newQuery()
 * @method static Builder|CostType query()
 * @method static Builder|CostType whereCreatedAt($value)
 * @method static Builder|CostType whereDescription($value)
 * @method static Builder|CostType whereId($value)
 * @method static Builder|CostType whereName($value)
 * @method static Builder|CostType whereSort($value)
 * @method static Builder|CostType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CostType extends Model
{
  protected $fillable = [
    'name',
    'description',
    'sort',
  ];

  /**
   * Последняя запись
   *
   * @return int
   */
  public static function getLastOrder(): int
  {
    return self::where('sort', '>', 0)
        ->orderBy('sort', 'DESC')
        ->first()
        ->sort ?? 0;
  }

  /**
   * Периоды для данного типа
   *
   * @return HasMany
   */
  public function periods(): HasMany
  {
    return $this->hasMany(Period::class);
  }
}
