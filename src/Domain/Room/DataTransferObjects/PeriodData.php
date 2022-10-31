<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Room\Models\Period;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Lazy;

final class PeriodData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $start_at,
        public string $end_at,
        public int $cost_type_id,
        public ?string $description,
        public ?Carbon $created_at,
        public ?string $info,
        public readonly null|Lazy|CostTypeData $type,
    ) {
    }

    public static function fromModel(Period $period): self
    {
        return self::from([
            ...$period->toArray(),
            'created_at' => $period->created_at,
            'type' => Lazy::whenLoaded('type', $period, fn () => CostTypeData::from($period->type)),
        ]);
    }
}
