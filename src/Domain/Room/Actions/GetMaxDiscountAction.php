<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Hotel\DataTransferObjects\MinCostsData;
use Lorisleiva\Actions\Action;
use Spatie\LaravelData\DataCollection;

/**
 * @method static int run(DataCollection<MinCostsData> $costs)
 */
final class GetMaxDiscountAction extends Action
{    
    /**    
     * @param \Spatie\LaravelData\DataCollection<MinCostsData> $costs
     * @return int
     */
    public function handle(DataCollection $costs): int
    {
        $maxDiscount = 0;
        foreach ($costs as $cost) {
            if (!$cost->cost_period)
                continue;
            
            $maxDiscount = $cost->cost_period->discount > $maxDiscount ? $cost->cost_period->discount : $maxDiscount;
        }

        return $maxDiscount;
    }
}
