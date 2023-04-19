<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(?string $search)
 */
final class SearchHotelsAction extends Action
{
    /**
     * @param  string|null $search
     * @return Collection
     */
    public function handle(?string $search): Collection
    {
        if (is_null($search) || empty(trim($search)))
            return new Collection();

        /** @var int $limit */
        $limit = config('search.limit');
        
        return Hotel::setEagerLoads([])
            ->with(['address'])
            ->where('name', 'LIKE', '%'.$search.'%')
            ->moderated()
            ->withRooms()
            ->orderBy(\DB::raw("POSITION('".$search."' IN name)"), 'asc')         
            ->orderBy('name')
            ->take($limit)->get();
    }
}
