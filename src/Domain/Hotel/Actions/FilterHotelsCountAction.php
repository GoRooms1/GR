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
 * @method static int run(array $filters)
 */
final class FilterHotelsCountAction extends Action
{
    /**
     * @param  array<string, string>  $filters
     * @return int
     */
    public function handle(array $filters): int
    {
        /** @var HotelBuilder $result */
        $result = app(Pipeline::class)
            ->send(Hotel::query())
            ->through($this->filters($filters))
            ->thenReturn();        
        /** @var int $data */
        $data = $result->moderated()->withRooms()->count();
        
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
