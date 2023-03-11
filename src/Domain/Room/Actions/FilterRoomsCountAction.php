<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Room\Builders\RoomBuilder;
use Domain\Room\Filters\Filters;
use Domain\Room\Models\Room;
use Illuminate\Pipeline\Pipeline;
use Lorisleiva\Actions\Action;
use Parent\Filters\Filter;

/**
 * @method static int run(array $filters, array $hotelFilters)
 */
final class FilterRoomsCountAction extends Action
{
    /**
     * @param  array<string, string>  $filters
     * @param  array<string, string>  $hotelFilters
     * @return int
     */
    public function handle(array $filters, array $hotelFilters = []): int
    {
        /** @var RoomBuilder $result */
        $result = app(Pipeline::class)
            ->send(Room::query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->moderated()
            ->hotelIn(FilterHotelsAction::run($hotelFilters, false)->pluck('id')->toArray());
        $data = $result->count();

        return $data;
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
