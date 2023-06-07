<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use App\Models\FilterCost;
use Domain\Room\DataTransferObjects\CostTypeKeyNameData;
use Domain\Room\DataTransferObjects\FilterCostRangeData;
use Domain\Room\Models\CostType;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static DataCollection run()
 */
final class GetCostTypesWithCostRangesKeyNameDataAction extends Action
{
    /**
     * @return DataCollection
     */
    public function handle(): DataCollection
    {
        $keyNames = new DataCollection(CostTypeKeyNameData::class, []);
        /** @var CostType[] $costTypes */
        $costTypes = CostType::with('filterCosts')->orderBy('sort')->get();

        foreach ($costTypes as $costType) {
            $ranges = new DataCollection(FilterCostRangeData::class, []);
            /** @var FilterCost[] $filterCosts */
            $filterCosts = $costType->filterCosts->sortBy('cost');
            $from = 0;
                        
            foreach ($filterCosts as $cost) {
                /** @var int $to */
                $to = $cost->cost ?? 0;
                $ranges[] = FilterCostRangeData::fromRange($from, $to);
                $from = $to;
            }
            if ($from > 0) {
                $ranges[] = FilterCostRangeData::fromRange($from, 0);
            }

            $keyNames[] = new CostTypeKeyNameData(
                key: $costType->id,
                name: $costType->name,
                cost_ranges: $ranges
            );
        }

        return $keyNames;
    }
}
