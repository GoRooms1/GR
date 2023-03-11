<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Filters\Filters;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Lorisleiva\Actions\Action;
use Parent\Filters\Filter;

/**
 * @method static LengthAwarePaginator<int, Room> run(array $filters, array $hotelFilters, ?bool $paginate)
 */
final class FilterRoomsAction extends Action
{
    /**
     * @param  array<string, string>  $filters
     * @param  array<string, string>  $hotelFilters
     * @param  bool  $paginate
     * @return Collection<int, Room>|LengthAwarePaginator<Room>
     */
    public function handle(array $filters, array $hotelFilters = [], bool $paginate = false): Collection | LengthAwarePaginator
    {
        /** @var RoomBuilder $rooms */
        $rooms = app(Pipeline::class)
            ->send(Room::query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->moderated()
            ->hotelIn(FilterHotelsAction::run($hotelFilters, false)->pluck('id')->toArray());

        if ($paginate) {
            /** @var int $perPage */
            $perPage = config('pagination.rooms_per_page');

            return $rooms->paginate($perPage);
        }

        return $rooms->get();
    }

    /**
     * @param  array<string, string|array>  $filters
     * @return Filter[]
     */
    protected function filters(array $filters): array
    {
        $result = [];
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    if ($v && Filters::tryFrom($key)) {
                        $result[] = Filters::from($key)->createFilter($v);
                    }
                }
            } else {
                if ($value && Filters::tryFrom($key)) {
                    $result[] = Filters::from($key)->createFilter($value);
                }
            }
        }

        return $result;
    }
}
