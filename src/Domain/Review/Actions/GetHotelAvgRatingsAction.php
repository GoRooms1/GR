<?php

declare(strict_types=1);

namespace Domain\Review\Actions;

use Domain\Hotel\Models\Hotel;
use Domain\Review\Models\Rating;
use Illuminate\Support\Collection;
use Parent\Actions\Action;

/**
 * @static Collection run(Hotel $hotel)
 */
final class GetHotelAvgRatingsAction extends Action
{
    public function handle(Hotel $hotel): Collection
    {
        return Rating::join('rating_categories', 'rating_categories.id', '=', 'ratings.category_id')
            ->groupBy('category_id', 'rating_categories.name')
            ->selectRaw('ratings.category_id, rating_categories.name as category_name, avg(ratings.value) as value')
            ->whereIn('ratings.review_id', function($query) use ($hotel) {
                $query->select('id')->from('reviews')->where('hotel_id', $hotel->id);
            })
            ->orderBy('rating_categories.sort')
            ->get();
    }
}
