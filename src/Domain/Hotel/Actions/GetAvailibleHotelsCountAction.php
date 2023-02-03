<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;


use Domain\Hotel\Models\Hotel;
use Lorisleiva\Actions\Action;

/**
 * @method static int run()
 */
final class GetAvailibleHotelsCountAction extends Action
{
    public function handle(): int
    {
        return Hotel::moderated()->withRooms()->count();
    }
}
