<?php

declare(strict_types=1);

namespace Domain\Hotel\Builders;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Domain\Hotel\Filters\Filters;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Models\Room;
use Domain\Search\DataTransferObjects\RoomParamsData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Parent\Filters\Filter;

/**
 * @template TModelClass of \Domain\Hotel\Models\Hotel
 * @extends Builder<TModelClass>
 */
final class HotelBuilder extends Builder
{
    public function popular(): self
    {
        return $this->where('is_popular', true);
    }

    public function moderated(): self
    {
        return $this->where('moderate', false)->where('show', true)->where('old_moderate', true);
    }

    public function withRooms(): self
    {
        return $this->withCount(['rooms' => function ($query) {
            $query->where('moderate', false);
        }])
        ->having('rooms_count', '>', 0);
    }

    /**
     * @param  HotelParamsData  $filters
     * @return HotelBuilder
     */
    public function filter(HotelParamsData $filters): self
    {
        /** @var HotelBuilder $builder */
        $builder = app(Pipeline::class)
            ->send($this)
            ->through($this->filters($filters))
            ->thenReturn();

        return $builder;
    }

    /**     
     * @param HotelParamsData $hotelFilters
     * @param RoomParamsData $roomFilters
     * @return HotelBuilder
     */
    public function filterWithRooms(HotelParamsData $hotelFilters, RoomParamsData $roomFilters): self
    {
        /** @var HotelBuilder $builder */
        $builder = app(Pipeline::class)
            ->send($this)
            ->through($this->filters($hotelFilters))
            ->thenReturn();

        return $builder            
            ->whereHas('rooms', function ($query) use ($roomFilters) {
                $query->filterForHotels($roomFilters);
            });
    }

    /**
     * @param  HotelParamsData  $filters
     * @return HotelBuilder
     */
    public function filterForRooms(HotelParamsData $filters): self
    {
        /** @var HotelBuilder $builder */
        $builder = app(Pipeline::class)
            ->send($this)
            ->through($this->filters($filters))
            ->thenReturn();

        return $builder;
    }

    /**
     * @param  HotelParamsData  $filters
     * @return Filter[]
     */
    private function filters(HotelParamsData $filters): array
    {
        $result = [];
        /** @var array<string, string|int|bool|null> */
        $mainFilters = array_filter($filters->toArray(), function ($k) {
            return $k != 'attrs';
        }, ARRAY_FILTER_USE_KEY);

        if ($filters->metro != null && $filters->city != null) {
            $mainFilters['united_city'] = $mainFilters['city'].';'.$filters->metro;
            unset($mainFilters['city']);
        }
        
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
}
