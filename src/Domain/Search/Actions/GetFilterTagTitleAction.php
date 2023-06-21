<?php

declare(strict_types=1);

namespace Domain\Search\Actions;

use Cache;
use Domain\Attribute\Model\Attribute;
use Domain\Hotel\Models\HotelType;
use Domain\Room\DataTransferObjects\FilterCostRangeData;
use Domain\Room\Models\CostType;
use Lorisleiva\Actions\Action;
use Str;

final class GetFilterTagTitleAction extends Action
{   
    /**     
     * @param String $key
     * @param String $value
     * @return String
     */
    public function handle(String $key, String $value): String
    {        
        $title = $value;

        if ($key === 'is_hot')
                return 'Горящие';

        if ($key === 'cashback')
            return 'Кэшбэк';

        if ($key === 'low_cost')
            return 'Low Cost';

        if ($key === 'moderate')
            return 'На модерации';

        if (Str::startsWith($key, 'attr_')) {            
            $title = Cache::remember('tags_'.$key.'_'.$value, now()->addDays(365), function () use ($value){            
                return optional(Attribute::find($value))->name;
            });
            
            return $title;
        }

        if ($key === 'type') {           
            $title = Cache::remember('tags_'.$key.'_'.$value, now()->addDays(365), function () use ($value){            
                return optional(HotelType::find($value))->name;
            });
            
            return $title;
        }

        if ($key === 'period_cost') {
            $title = Cache::remember('tags_'.$key.'_'.$value, now()->addDays(365), function () use ($value){            
                $params = explode('_', $value);
                $cost_type_id = $params[0] ?? null;
                $fromTo = $params[1] ?? null;

                if ($fromTo == null || $cost_type_id == null) {
                    return $value;
                }
                
                $from = intval(explode('-', $fromTo)[0] ?? 0);
                $to = intval(explode('-', $fromTo)[1] ?? 0);
                $to = $to > 99999999 ? 0 : $to;

                $costTypeName = optional(CostType::find($cost_type_id))->name;
                $costRange = FilterCostRangeData::fromRange($from, $to);

                return $costTypeName.': '.$costRange->name;
            });
            
            return $title;
        }

        return $title;
    }
}
