<?php

declare(strict_types=1);

namespace Domain\Room\Models;

use App\Models\FilterCost;
use Domain\Room\DataTransferObjects\CostTypeData;
use Domain\Room\Factories\CostTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * Тип для стоимости (На день на ночь и тп)
 *
 * @property int                          $id
 * @property string                       $name
 * @property int                          $sort
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $description
 * @property string|null                  $slug
 * @property-read Collection<Period>|Period[]     $periods
 * @property-read int|null                $periods_count
 * @property-read Collection|FilterCost[] $filterCosts
 * @property-read int|null                $filter_costs_count
 *
 * @method static Builder|CostType newModelQuery()
 * @method static Builder|CostType newQuery()
 * @method static Builder|CostType query()
 * @method static Builder|CostType whereCreatedAt($value)
 * @method static Builder|CostType whereDescription($value)
 * @method static Builder|CostType whereId($value)
 * @method static Builder|CostType whereName($value)
 * @method static Builder|CostType whereSort($value)
 * @method static Builder|CostType whereUpdatedAt($value)
 * @method static Builder|CostType whereSlug($value)
 * @mixin Eloquent
 */
final class CostType extends Model
{
    use WithData;
    use HasFactory;

    protected string $dataClass = CostTypeData::class;

    protected $fillable = [
        'name',
        'description',
        'sort',
        'slug',
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

    public function filterCosts(): HasMany
    {
        return $this->hasMany(FilterCost::class, 'cost_type_id', 'id');
    }

    protected static function newFactory(): CostTypeFactory
    {
        return CostTypeFactory::new();
    }
}
