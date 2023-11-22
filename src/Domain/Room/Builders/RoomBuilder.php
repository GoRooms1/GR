<?php

declare(strict_types=1);

namespace Domain\Room\Builders;

use Carbon\Carbon;
use Domain\Hotel\Builders\HotelBuilder;
use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Scopes\ModerationScope;
use Domain\Room\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Parent\Filters\Filter;
use Schema;

/**
 * @template TModelClass of \Domain\Room\Models\Room
 * @extends Builder<TModelClass>
 */
final class RoomBuilder extends \Illuminate\Database\Eloquent\Builder
{
    public function hot(): self
    {
        return $this->whereHas('costs', function ($query) {
            $query
                ->where('value', '!=', '0')
                ->whereHas('cost_periods', function ($query) {
                    $query
                        ->where('is_active', true)
                        ->where('date_from', '<=', Carbon::now()->startOfDay())
                        ->where('date_to', '>=', Carbon::now()->startOfDay())
                        ->where('discount', '>=', 3);
                });            
            })
            ->orderByRaw(
                '(
                    SELECT max(cp.discount) 
                    FROM cost_periods as cp 
                    WHERE cp.cost_id IN (SELECT c.id FROM costs as c WHERE c.room_id = rooms.id) 
                    AND cp.is_active = 1 
                    AND cp.date_from <= CURDATE()
                    AND cp.date_to >= CURDATE()
                ) DESC'
            );
    }

    public function moderated(): self
    {
        return $this->whereHas('hotel', function ($query) {
            $query->where('moderate', false)->where('show', true)->where('old_moderate', true);
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

    public function withAllCosts(): self
    {
        return $this->with(['costs' => function($q) {
            return $q->selectRaw(
                '*'
            )->from('cost_types')       
            ->leftJoin('periods','cost_types.id','=','periods.cost_type_id')
            ->leftJoin('costs','costs.period_id','=','periods.id')               
            ->orderBy('cost_types.sort','asc');
        }]);
    }


    /**
     * @param  array<int>  $hotels_ids
     * @return RoomBuilder
     */
    public function hotelIn(array $hotels_ids): self
    {
        return $this->whereIn('hotel_id', $hotels_ids);
    }

    /**
     * @param  RoomParamsData  $filters
     * @param  HotelParamsData  $hotelFilters
     * @return RoomBuilder
     */
    public function filter(RoomParamsData $filters, HotelParamsData $hotelFilters): self
    {
        /** @var RoomBuilder $builder */
        $builder = app(Pipeline::class)
            ->send($this)
            ->through($this->filters($filters))
            ->thenReturn();
        
        return $builder            
            ->whereIn('hotel_id', Hotel::withoutGlobalScope(ModerationScope::class)->filterForRooms($hotelFilters)->select('id'));                        
    }

    public function filterForHotels(RoomParamsData $filters): self
    {
        /** @var RoomBuilder $builder */
        $builder = app(Pipeline::class)
            ->send($this)
            ->through($this->filters($filters))
            ->thenReturn();
        
        return $builder;       
    }

    /**
     * @param  RoomParamsData  $filters
     * @return Filter[]
     */
    private function filters(RoomParamsData $filters): array
    {
        $result = [];
        /** @var array<string, string|int|bool|null> */
        $mainFilters = array_filter($filters->toArray(), function ($k) {
            return $k != 'attrs';
        }, ARRAY_FILTER_USE_KEY);

        foreach ($mainFilters as $key => $value) {
            if ($value != null && Filters::tryFrom($key)) {
                $result[] = Filters::from($key)->createFilter(strval($value));
            }
        }

        /** @var array<int> */
        $filterAttrs = $filters->attrs;
        foreach ($filterAttrs as $value) {
            if ($value != null && Filters::tryFrom('attrs')) {
                $result[] = Filters::from('attrs')->createFilter(strval($value));
            }
        }

        return $result;
    }

    /**    
     * @return RoomBuilder
     */
    public function sort(?String $sort = null): self
    {     
        if (empty($sort))
            return $this;

        $sort = strtolower($sort);
        $sortField = 'created_at';
        $sortDirection = 'desc';

        $sortArray = explode(',', $sort);
        
        if (in_array($sortArray[0], Schema::getColumnListing('rooms')))
            $sortField = $sortArray[0];

        if (isset($sortArray[1]) && in_array($sortArray[1], ['asc','desc']))
            $sortDirection = $sortArray[1];

        return $this->orderBy($sortField, $sortDirection);                        
    }    
}
