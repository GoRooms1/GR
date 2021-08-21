<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Стоимость комнат п периодам
 */
class Cost extends Model
{
  /**
   * Columns
   *
   * @var string[]
   */
  protected $fillable = [
    'value',
    'room_id',
    'period_id'
  ];

  public function room(): BelongsTo
  {
    return $this->belongsTo(Room::class);
  }

  public function period(): BelongsTo
  {
    return $this->belongsTo(Period::class);
  }

  public function scopeMinValues(Builder $query, array $rooms)
  {
    return $query->whereIn('room_id', $rooms)->min('value')->with(['period.type' => function($query){
      $query->groupBy('id');
    }]);
  }
}
