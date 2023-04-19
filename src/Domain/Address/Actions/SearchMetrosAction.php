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

        return Metro::select(['metros.name', 'metros.color', 'addresses.city'])            
            ->leftJoin('hotels', 'hotels.id', '=', 'metros.hotel_id')
            ->leftJoin('addresses', 'hotels.id', '=', 'addresses.hotel_id')           
            ->where('metros.name', 'LIKE', '%'.$search.'%')       
            ->whereNotNull('addresses.city')
            ->orderBy(\DB::raw("POSITION('".$search."' IN metros.name)"), 'asc')         
            ->orderBy('metros.name')            
            ->get()
            ->unique(function ($item) {
                return $item['name'].$item['city'];
            })
            ->take($limit)
            ->flatten();
    }
}
