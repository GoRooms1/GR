<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Domain\Room\Models\Room;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetFavoriteRoomsAction extends Action
{     
    public function handle(): Collection
    {       
        $rooms = session()->get('favorites', collect());
        
        return $rooms;
    }
}
