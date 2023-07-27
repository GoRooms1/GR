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
final class GetSubscribedHotelsAction extends Action
{
    public function handle(int $telegram_id): Collection
    {  
        return Hotel::select('hotels.*')
            ->withoutGlobalScopes()
            ->join('hotel_user', 'hotels.id', '=', 'hotel_user.hotel_id')
            ->join('users', 'users.id', '=', 'hotel_user.user_id')         
            ->where('users.telegram_id', $telegram_id)
            ->get();
    }
}
