<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\Models\Cost;

final class MinCostsData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $info,
        public readonly float $value,
        public readonly ?string $description = '',
    ) {
    }

    public static function fromModel(Cost $cost): self
    {
        return self::from([
            'id' => $cost->period->type->id,
            'name' => str_replace('на ', '', mb_strtolower($cost->period->type->name)),
            'info' => GenerateInfoDescForPeriod::run($cost->period->start_at, $cost->period->end_at),
            'value' => $cost->value
        ]);
    }
}
