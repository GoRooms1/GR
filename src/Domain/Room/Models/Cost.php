<?php

declare(strict_types=1);

namespace Domain\Room\Models;

use Domain\Room\DataTransferObjects\CostData;
use Domain\Room\Factories\CostFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\WithData;

/**
 * Стоимость комнат пo периодам
 *
 * @property int         $id
 * @property float|null  $value
 * @property int         $room_id
 * @property int         $period_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Period $period
 * @property-read Room   $room
 *
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
final class Cost extends Model
{
    use WithData;
    use HasFactory;

    protected string $dataClass = CostData::class;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'value',
        'avg_value',
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

    public function costType(): HasOneThrough
    {
        return $this->hasOneThrough(Period::class, CostType::class);
    }

    public function costsCalendars(): HasMany
    {
        return $this->hasMany(CostsCalendar::class, 'cost_id', 'id');
    }    


    protected static function newFactory(): CostFactory
    {
        return CostFactory::new();
    }
}
