<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(Room $room)
 */
final class GetRoomFullNameAction extends Action
{
    public function handle(Room $room): string
    {
       /** @var string $roomName */
       $roomName = ($room->number ? $room->number.' / ' : '')
        .$room->name
        .(strlen($room->category->name ?? '') > 1 ? ' ('.$room->category->name.')' : '');
       
       return trim($roomName);
    }
}
