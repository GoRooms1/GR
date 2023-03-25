<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(?string $search)
 */
final class SearchMetrosAction extends Action
{
    /**     
     * @param string|null $search
     * @return Collection
     */
    public function handle(?string $search): Collection
    {
        if (is_null($search) || empty(trim($search)))
            return new Collection();

        /** @var int $limit */
        $limit = config('search.limit');

        return Metro::with('hotel')
            ->where('name', 'LIKE', '%'.$search.'%')       
            ->whereHas('hotel.address', function($q) {
                return $q->whereNotNull('city');
            })          
            ->orderBy('name')            
            ->get()
            ->unique(function ($item) {
                return $item['name'].$item['hotel.address.city'];
            })
            ->take($limit)
            ->flatten();
    }
}
