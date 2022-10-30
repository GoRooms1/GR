<?php

declare(strict_types=1);

namespace Domain\Room\Models;

use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\Actions\GetEndingValue;
use Domain\Room\DataTransferObjects\PeriodData;
use Domain\Room\Factories\PeriodFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * Domain\Room\Models\Period
 *
 * @property int           $id
 * @property string        $start_at
 * @property string|null   $end_at
 * @property int           $cost_type_id
 * @property string|null   $description
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property-read string   $info
 * @property-read CostType $type
 *
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
final class Period extends Model
{
    use WithData;
    use HasFactory;

    protected string $dataClass = PeriodData::class;

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
     * @var string[]
     */
    protected $appends = [
        'info',
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
        return GenerateInfoDescForPeriod::run($this->start_at, $this->end_at ?? '');
    }

    /**
     * Русское окончание при сокращениие цифрами до 20 часов
     *
     * @param  string|int  $value
     * @return string
     */
    public function theEnding(string|int $value): string
    {
        return GetEndingValue::run((int) $value);
    }

    protected static function newFactory(): PeriodFactory
    {
        return PeriodFactory::new();
    }
}
