<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\Actions\GetActualCostPeriodsByCostIdAction;
use Domain\Room\Actions\GetCurrentCostPeriodAction;
use Domain\Room\DataTransferObjects\PeriodData;
use Domain\Room\Models\Cost;
use Domain\Room\Models\CostPeriod;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

final class RoomCostsData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $info,
        public readonly float|string $value,
        public readonly ?string $description,
        public readonly ?PeriodData $period,
        public readonly CostPeriod|null $cost_period,
        #[DataCollectionOf(CostPeriodData::class)]
        public readonly null|DataCollection $actual_cost_periods,        
    ) {
    }

    public static function fromModel(Cost $cost): self
    {        
        return self::from([
            'id' => $cost->period->type->id,
            'name' => $cost->value > 0 ? str_replace('на ', '', mb_strtolower($cost->period->type->name)) : $cost->period->type->name,
            'info' => GenerateInfoDescForPeriod::run($cost->period->start_at, $cost->period->end_at),
            'value' => $cost->value,
            'description' => $cost->value > 0 ? '' : 'Не предоставляется',
            'period' => $cost->period->getData(),
            'cost_period' => GetCurrentCostPeriodAction::run($cost->id),
            'actual_cost_periods' => CostPeriodData::collection(GetActualCostPeriodsByCostIdAction::run($cost->id)),
        ]);
    }    
}
