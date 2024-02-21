<?php

declare(strict_types=1);

namespace Domain\Review\Actions;

use Domain\Review\Models\Rating;
use Domain\Review\Models\Review;
use Parent\Actions\Action;

/**
 * @static float|int run(Review $review)
 */
final class GetReviewAvgRatingValueAction extends Action
{
    public function handle(Review $review): float|int
    {
        $rating = Rating::whereIn('review_id', function($query) use ($review) {
            $query->select('id')->from('reviews')->where('review_id', $review->id);
        })->get()->avg('value');

        if ($rating === null) {
            return 0;
        }

        return round($rating, 1);
    }
}
