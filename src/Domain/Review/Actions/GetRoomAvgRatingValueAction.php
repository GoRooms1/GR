<?php

declare(strict_types=1);

namespace Domain\Review\Actions;

use Domain\Review\Models\Rating;
use Domain\Room\Models\Room;
use Illuminate\Support\Collection;
use Parent\Actions\Action;

/**
 * @static float|int run(Room $room)
 */
final class GetRoomAvgRatingValueAction extends Action
{
    public function handle(Room $room): float|int
    {
        $rating = Rating::whereIn('review_id', function($query) use ($room) {
            $query->select('id')->from('reviews')->where('room_id', $room->id);
        })->get()->avg('value');

        if ($rating === null) {
            return 0;
        }

        return round($rating, 1);
    }
}
