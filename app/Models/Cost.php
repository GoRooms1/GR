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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Стоимость комнат п периодам
 *
 * @property int         $id
 * @property float|null  $value
 * @property int         $room_id
 * @property int         $period_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Period $period
 * @property-read Room   $room
 * @method static Builder|Cost minValues($rooms)
 * @method static Builder|Cost newModelQuery()
 * @method static Builder|Cost newQuery()
 * @method static Builder|Cost query()
 * @method static Builder|Cost whereCreatedAt($value)
 * @method static Builder|Cost whereId($value)
 * @method static Builder|Cost wherePeriodId($value)
 * @method static Builder|Cost whereRoomId($value)
 * @method static Builder|Cost whereUpdatedAt($value)
 * @method static Builder|Cost whereValue($value)
 * @mixin Eloquent
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
    'period_id',
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
    return $query
      ->whereIn('room_id', $rooms)->min('value')
      ->with(['period.type' => function ($query) {
        $query->groupBy('id');
      },
      ]);
  }
}
