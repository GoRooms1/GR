<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Period
 *
 * @property int $id
 * @property string $start_at
 * @property string|null $end_at
 * @property int $cost_type_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $info
 * @property-read CostType $type
 * @method static Builder|Period newModelQuery()
 * @method static Builder|Period newQuery()
 * @method static Builder|Period query()
 * @method static Builder|Period whereCostTypeId($value)
 * @method static Builder|Period whereCreatedAt($value)
 * @method static Builder|Period whereDescription($value)
 * @method static Builder|Period whereEndAt($value)
 * @method static Builder|Period whereId($value)
 * @method static Builder|Period whereStartAt($value)
 * @method static Builder|Period whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
    'type'
  ];

  protected $appends = [
    'info'
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

    return 'От ' . $this->start_at . $this->theEnding($this->start_at) . ' часов';
  }

  /**
   * Русское окончание при сокращениие цифрами до 20 часов
   *
   * @param $value
   * @return string
   */
  public function theEnding($value): string
  {
    $value = (int)$value;
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
