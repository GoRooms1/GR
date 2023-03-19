<?php

declare(strict_types=1);

namespace Domain\Room\Builders;

use Domain\Filter\DataTransferObjects\HotelParamsData;
use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Filter\DataTransferObjects\RoomParamsData;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Room\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Parent\Filters\Filter;

/**
 * @template TModelClass of \Domain\Room\Models\Room
 * @extends Builder<TModelClass>
 */
final class RoomBuilder extends \Illuminate\Database\Eloquent\Builder
{
    public function hot(): self
    {
        return $this->where('is_hot', true);
    }

    public function moderated(): self
    {
        return $this->whereHas('hotel', function ($query) {
            $query->where('moderate', false)->where('show', true);
        })
        ->where('moderate', false);
    }

    public function lowCost(): self
    {
        return $this->whereHas('costs', function ($query) {
            $query
            ->where('value', '!=', '0')
            ->where('value', '<', function ($query) {
                $query->from('filter_costs')->where('cost_type_id', 1)->selectRaw('MIN(cost)');
            })
            ->whereHas('period', function ($query) {
                $query->where('cost_type_id', 1);
            });
        });
    }

    /**     
     * @param array<int> $hotels_ids
     * @return RoomBuilder
     */
    public function hotelIn(array $hotels_ids): self
    {
        return $this->whereIn('hotel_id', $hotels_ids);
    }

    /**    
     * @param RoomParamsData $filters
     * @param HotelParamsData $hotelFilters
     * @return RoomBuilder
     */
    public function filter(RoomParamsData $filters, HotelParamsData $hotelFilters): self
    {
        /** @var RoomBuilder $builder*/
        $builder = app(Pipeline::class)
            ->send($this)
            ->through($this->filters($filters))
            ->thenReturn();
        
        /** @var array<int> */
        $hotel_ids = FilterHotelsAction::run($hotelFilters)->pluck('id')->toArray();

        return $builder
            ->moderated()                
            ->hotelIn($hotel_ids);          
    }

    /**
     * @param  RoomParamsData  $filters
     * @return Filter[]
     */
    private function filters(RoomParamsData $filters): array
    {
        $result = [];
        /** @var array<string, string|int|bool|null> */        
        $mainFilters = $filters->except('attributes')->toArray();
        foreach ($mainFilters as $key => $value) {
            if ($value != null && Filters::tryFrom($key))
                $result[] = Filters::from($key)->createFilter(strval($value));
        }

        /** @var array<int> */
        $filterAttrs = $filters->attributes;        
        foreach ($filterAttrs as $value) {
            if ($value != null && Filters::tryFrom('attributes'))
                $result[] = Filters::from('attributes')->createFilter(strval($value));
        }

        return $result;
    }
}
