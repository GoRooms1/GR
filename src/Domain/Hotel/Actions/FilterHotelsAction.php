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
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method static Collection<int, Hotel> run(array $filters, bool $paginate?)
 */
final class FilterHotelsAction extends Action
{
    /**
     * @param  array<string, string>  $filters
     * @param bool  $paginate
     * @return Collection<int, Hotel>
     */
    public function handle(array $filters, bool $paginate = false): Collection | LengthAwarePaginator
    {
        /** @var HotelBuilder $result */
        $result = app(Pipeline::class)
            ->send(Hotel::query())
            ->through($this->filters($filters))
            ->thenReturn()
            ->moderated()->withRooms();
        if ($paginate)
            $data = $result->paginate(config('pagination.hotels_per_page'));
        else
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
            if (is_array($value)) {            
                foreach ($value as $k => $v) {                    
                    if ($v && Filters::tryFrom($key))
                        $result[] = Filters::from($key)->createFilter($v);                    
                }
            }
            else {
                if ($value && Filters::tryFrom($key))
                    $result[] = Filters::from($key)->createFilter($value);
            }
            
        }

        return $result;
    }
}
