<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use App\User;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Room\Models\Room;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(int $room_id)
 */
final class ToggleFavoriteRoomAction extends Action
{     
    public function handle(int $room_id)
    {        
        $room = Room::find($room_id);
        $user = null;
        
        if (auth()->check() && auth()->user()->is_client) {
            $user = User::find(auth()->id());
        }
       
        $rooms = session()->get('favorites', collect());
        $isFavorite = $rooms->contains(function ($obj, $key) use ($room_id) {
            return $obj->id === $room_id;
        });
        
        if ($isFavorite) {
            $rooms = $rooms->filter(function ($obj, $key)  use ($room_id) {
                return $obj->id != $room_id;
            });

            if ($user) {
                $user->favorites()->detach($room_id);
            }
        }
        else if ($room != null){
            $rooms->push(RoomCardData::fromModel($room));

            if ($user) {
                $user->favorites()->attach($room_id);
            }
        }
        
        session()->put('favorites', $rooms);
    }
}
