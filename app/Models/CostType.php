<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Тип для стоимости (На день на ночь и тп)
 */
class CostType extends Model
{
  protected $fillable = [
    'name',
    'description',
    'sort'
  ];

  /**
   * Последняя запись
   * @return int
   */
  public static function getLastOrder(): int
  {
    return self::where('sort', '>', 0)->orderBy('sort', 'DESC')->first()->sort ?? 0;
  }

  /**
   * Периоды для данного типа
   * @return HasMany
   */
  public function periods (): HasMany
  {
    return $this->hasMany(Period::class);
  }
}
