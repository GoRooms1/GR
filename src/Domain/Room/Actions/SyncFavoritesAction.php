<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use App\User;
use Domain\Room\DataTransferObjects\RoomCardData;
use Lorisleiva\Actions\Action;

/**
 * @method static void run()
 */
final class SyncFavoritesAction extends Action
{     
    public function handle()    
    {        
        if (!auth()->check())
            return;

        if (!auth()->user()->is_client)
            return;

        $user = User::find(auth()->id());        
        $roomsInSession = session()->get('favorites', collect());
        $roomsInBase = $user->favorites;
        
        if ($roomsInBase->count() == 0 && $roomsInSession->count() > 0) {
            $user->favorites()->sync($roomsInSession->pluck('id')->toArray());
            return;
        }

        if ($roomsInBase->count() > 0) {
            $roomsInSession = collect();

            foreach ($roomsInBase as $room) {
                $roomsInSession->push(RoomCardData::fromModel($room));
            }

            session()->put('favorites', $roomsInSession);
        }
    }
}
