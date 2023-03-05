<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\DataTransferObjects\CostTypeKeyNameData;
use Domain\Room\DataTransferObjects\FilterCostRangeData;
use Domain\Room\Models\CostType;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static mixed run()
 */
final class GetCostTypesWithCostRangesAsParamsAction extends Action
{
    /**     
     * @return mixed
     */
    public function handle()
    {
        $result = [];
        $cost_types = CostType::with('filterCosts')->orderBy('sort')->get();        
        
        foreach ($cost_types as $type) {
            $ranges = [];
            $filter_costs = $type->filterCosts ?? [];            
            $from = 0;
            $to = 0;
            foreach ($filter_costs->sortBy('cost') as $i=>$cost) {
                $to = $cost->cost;                
                $ranges[] = FilterCostRangeData::fromRange($from, $to);
                $from = $to;
            }
            if ($from > 0) {
                $ranges[] = FilterCostRangeData::fromRange($from, 0);
            }           

            $result[] = new CostTypeKeyNameData(
                key: $type->id,
                name: $type->name,
                cost_ranges: new DataCollection(FilterCostRangeData::class, $ranges)           
            );
        }
        return new DataCollection(CostTypeKeyNameData::class, $result);
    }
}
