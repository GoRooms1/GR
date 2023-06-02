<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Domain\Hotel\Builders\HotelBuilder;
use Illuminate\Database\Eloquent\Builder;

final class ModerateFilter extends \Parent\Filters\Filter
{
    /**
     * @param  HotelBuilder  $builder
     * @param  \Closure  $next
     * @return Builder
     */
    public function handle(Builder $builder, \Closure $next): Builder
    {        
        if ($this->value != false)
            $builder->where(function($q) {
                $q->where('moderate', true)
                ->orWhereHas('media', function($q) {
                    $q
                        ->where('collection_name', 'images')
                        ->where('custom_properties->moderate', true);
                })
                ->orWhereHas('rooms', function($q) {
                    $q->where('moderate', true);
                })
                ->orDoesnthave('rooms')
                ->orWhereHas('rooms', function($q) {
                    $q->whereHas('media', function($q) {
                        $q
                            ->where('collection_name', 'images')
                            ->where('custom_properties->moderate', true);
                    });
                });
            });            

        return $next($builder);
    }
}
