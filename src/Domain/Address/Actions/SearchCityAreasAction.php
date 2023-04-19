<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(?string $search)
 */
final class SearchCityAreasAction extends Action
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
        
        return Address::distinct()->select('city_area', 'city')
            ->where('city_area', 'LIKE', '%'.$search.'%')
            ->orderBy(\DB::raw("POSITION('".$search."' IN city_area)"), 'asc')
            ->orderBy('city_area')->take($limit)->get();
    }
}
