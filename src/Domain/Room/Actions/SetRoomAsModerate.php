<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\DataTransferObjects\RoomData;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static RoomData run(Room $room)
 */
final class SetRoomAsModerate extends Action
{
    public function handle(Room $room): RoomData
    {
        $room->moderate = true;
        $room->save();

        return RoomData::fromModel($room);
    }
}
