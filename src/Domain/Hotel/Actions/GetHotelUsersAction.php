<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run(int $hotel_id)
 */
final class GetHotelUsersAction extends Action
{
    public function handle(int $hotel_id): Collection
    {       
        return User::select('users.*')
            ->withoutGlobalScopes()
            ->leftJoin('hotel_user', 'users.id', '=', 'hotel_user.user_id')
            ->leftJoin('hotels', 'users.id', '=', 'hotels.user_id')                   
            ->where('hotel_user.hotel_id', $hotel_id)
            ->orWhere('hotels.id', $hotel_id)          
            ->get();
    }
}
