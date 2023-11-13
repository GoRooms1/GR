<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Room\Actions\GenerateInfoDescForPeriod;
use Domain\Room\Actions\GetCurrentCostPeriodAction;
use Domain\Room\DataTransferObjects\CostPeriodData;
use Domain\Room\DataTransferObjects\PeriodData;
use Domain\Room\Models\Cost;
use Spatie\LaravelData\DataCollection;

final class MinCostsData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $info,
        public readonly float|string $value,
        public readonly ?string $description,
        public readonly ?PeriodData $period,
        public readonly ?CostPeriodData $cost_period,
    ) {
    }

    public static function fromModel(Cost $cost): self
    {
        $costPeriod = GetCurrentCostPeriodAction::run($cost->id);
        return self::from([
            'id' => $cost->period->type->id,
            'name' => $cost->value > 0 ? str_replace('на ', '', mb_strtolower($cost->period->type->name)) : $cost->period->type->name,
            'info' => GenerateInfoDescForPeriod::run($cost->period->start_at, $cost->period->end_at),
            'value' => $cost->value,
            'description' => $cost->value > 0 ? '' : 'Не предоставляется',
            'period' => $cost->period->getData(),
            'cost_period' => $costPeriod ? CostPeriodData::fromModel($costPeriod) : null,
        ]);
    }

    public static function fromJoinedModel($costs)
    {
        $result = [];
        
        foreach ($costs as $cost) {
            $result[] = new MinCostsData(
                id: $cost->cost_type_id,
                name: $cost->name,
                info: GenerateInfoDescForPeriod::run($cost->start_at, $cost->end_at),
                value: is_null($cost->value) ? 0 : $cost->value,
                description: $cost->value > 0 ? '' : 'Не предоставляется',
                period: new PeriodData(
                    id: $cost->period_id,
                    cost_type_id: $cost->cost_type_id,
                    start_at: $cost->start_at,
                    end_at: $cost->end_at,
                    description: null,
                    created_at: null,
                    info: null,
                    type: null,
                ),
                cost_period: null,
            );
        };

        return new DataCollection(MinCostsData::class, $result);
    }
}
