<?php

declare(strict_types=1);

namespace Domain\Review\Actions;

use Domain\Hotel\Models\Hotel;
use Domain\Review\Models\Rating;
use Parent\Actions\Action;

/**
 * @static float|int run(Hotel $hotel)
 */
final class GetHotelAvgRatingValueAction extends Action
{
    public function handle(Hotel $hotel): float|int
    {
        $rating = Rating::whereIn('review_id', function($query) use ($hotel) {
            $query->select('id')->from('reviews')->where('hotel_id', $hotel->id);
        })->get()->avg('value');

        if ($rating === null) {
            return 0;
        }

        return round($rating, 1);
    }
}
