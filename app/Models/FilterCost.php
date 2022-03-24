<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\FilterCost
 *
 * @property int           $id
 * @property int|null      $cost
 * @property int           $cost_type_id
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property-read CostType $costType
 * @method static Builder|FilterCost newModelQuery()
 * @method static Builder|FilterCost newQuery()
 * @method static Builder|FilterCost query()
 * @method static Builder|FilterCost whereCost($value)
 * @method static Builder|FilterCost whereCostTypeId($value)
 * @method static Builder|FilterCost whereCreatedAt($value)
 * @method static Builder|FilterCost whereId($value)
 * @method static Builder|FilterCost whereUpdatedAt($value)
 * @mixin Eloquent
 */
class FilterCost extends Model
{
  use HasFactory;

  protected $fillable = [
    'cost',
  ];

  public function costType(): BelongsTo
  {
    return $this->belongsTo(CostType::class);
  }
}
