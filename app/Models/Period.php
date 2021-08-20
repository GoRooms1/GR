<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Period extends Model
{
  protected $fillable = [
    'start_at',
    'end_at',
    'description',
    'cost_type_id',
  ];

  /**
   * get methods
   *
   * @var string[]
   */
  protected $with = [
    'type',
  ];

  /**
   * Тип периода выбранного
   *
   * @return BelongsTo
   */
  public function type(): BelongsTo
  {
    return $this->belongsTo(CostType::class, 'cost_type_id');
  }

  /**
   * Get the info for font-end.
   *
   * @return string
   */
  public function getInfoAttribute(): string
  {
    if ($this->end_at) {
      return 'С ' . $this->start_at . ' до ' . $this->end_at;
    }

    return 'От ' . $this->start_at . $this->theEnding($this->start_at) .  ' часов';
  }

  /**
   * Русское окончание при сокращениие цифрами до 20 часов
   *
   * @param $value
   * @return string
   */
  public function theEnding ($value): string
  {
    $value = (int) $value;
    if ($value < 2) {
      return '-го';
    }

    if ($value < 5) {
      return '-x';
    }

    if ($value < 20) {
      return '-и';
    }

    return '';
  }

  public function __toString()
  {
     return "$this->info" . PHP_EOL .
      "Тип: {$this->type->name}";
  }
}
