<?php

declare(strict_types=1);

namespace Domain\Review\Actions;

use Domain\Review\Models\Rating;
use Domain\Room\Models\Room;
use Illuminate\Support\Collection;
use Parent\Actions\Action;

/**
 * @static Collection run(Room $room)
 */
final class GetRoomAvgRatingsAction extends Action
{
    public function handle(Room $room): Collection
    {
        return Rating::join('rating_categories', 'rating_categories.id', '=', 'ratings.category_id')
            ->groupBy('category_id', 'rating_categories.name')
            ->selectRaw('ratings.category_id, rating_categories.name as category_name, round(avg(ratings.value), 1) as value')
            ->whereIn('ratings.review_id', function($query) use ($room) {
                $query->select('id')->from('reviews')->where('room_id', $room->id);
            })
            ->orderBy('rating_categories.sort')
            ->get();
    }
}
