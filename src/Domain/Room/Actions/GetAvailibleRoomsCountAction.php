<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleRoomsCountAction extends Action
{
    public function handle(): int
    {
        return Room::moderated()->count();
    }
}
