<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Room\Models\Cost;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Lazy;

final class CostData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public ?float $value,
        public int $room_id,
        public int $period_id,
        public ?Carbon $created_at,
        public readonly null|Lazy|PeriodData $period,
        public readonly null|Lazy|RoomData $room,
    ) {
    }

    public static function fromModel(Cost $cost): self
    {
        return self::from([
            ...$cost->toArray(),
            'period' => Lazy::whenLoaded('period', $cost, fn () => PeriodData::from($cost->period)),
            'room' => Lazy::whenLoaded('room', $cost, fn () => RoomData::from($cost->room)),
        ]);
    }
}
