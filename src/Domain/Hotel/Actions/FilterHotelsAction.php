<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Filters\Filters;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Lorisleiva\Actions\Action;
use Parent\Filters\Filter;

/**
 * @method static Collection<int, Hotel> run(array $filters, ?bool $paginate)
 */
final class FilterHotelsAction extends Action
{
    /**
     * @param  array<string, string>  $filters
     * @param  bool  $paginate
     * @return Collection<int, Hotel>
     */
    public function handle(array $filters, bool $paginate = false): Collection | LengthAwarePaginator
    {
        // @todo Single Responsibility breaking. Need to create 2 classes
        /** @var HotelBuilder $hotels */
        $hotels = app(Pipeline::class)
            ->send(Hotel::query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->moderated()->withRooms();

        if ($paginate) {
            return $hotels->paginate(config('pagination.hotels_per_page'));
        }
        return $hotels->get();
    }

    /**
     * @param  array<string, string|array>  $filters
     * @return Filter[]
     */
    protected function filters(array $filters): array
    {
        $result = [];
/*        $filterCollection = collect($filters);
        $filterCollection->map(function (array|string $data) {

        })*/
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    if ($v && Filters::tryFrom($key)) {
                        $result[] = Filters::from($key)->createFilter($v);
                    }
                }
            } else {
                // @todo to separate function
                if ($value && Filters::tryFrom($key)) {
                    $result[] = Filters::from($key)->createFilter($value);
                }
            }
        }

        return $result;
    }

    private function createFilter(): Filter
    {

    }
}
