<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\Builders\HotelBuilder;
use Domain\Hotel\Filters\Filters;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;
use Lorisleiva\Actions\Action;
use Parent\Filters\Filter;

/**
 * @method static Collection<int, Hotel> run(array $filters)
 */
final class FilterHotelsAction extends Action
{
    /**
     * @param  array<string, string>  $filters
     * @return Collection<int, Hotel>
     */
    public function handle(array $filters): Collection
    {
        /** @var HotelBuilder $result */
        $result = app(Pipeline::class)
            ->send(Hotel::query())
            ->through($this->filters($filters))
            ->thenReturn();
        /** @var Collection<int, Hotel> $data */
        $data = $result->get();

        return $data;
    }

    /**
     * @param  array<string, string>  $filters
     * @return Filter[]
     */
    protected function filters(array $filters): array
    {
        $result = [];
        foreach ($filters as $key => $value) {
            $result[] = Filters::from($key)->createFilter($value);
        }

        return $result;
    }
}
