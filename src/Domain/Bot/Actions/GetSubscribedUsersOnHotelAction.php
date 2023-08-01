<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use App\User;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(int $hotel_id)
 */
final class GetSubscribedUsersOnHotelAction extends Action
{
    public function handle(int $hotel_id): Collection
    {  
        return User::select('users.*')
            ->withoutGlobalScopes()
            ->join('hotel_user', 'users.id', '=', 'hotel_user.user_id')                     
            ->where('hotel_user.hotel_id', $hotel_id)
            ->whereNotNull('users.telegram_id')
            ->get();
    }
}
