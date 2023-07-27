<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use App\User;
use Domain\Hotel\Models\Hotel;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(int $hotel_id, int $telegram_id)
 */
final class UnSubscribeAction extends Action
{
    public function handle(int $hotel_id, int $telegram_id): string
    {        
        $user = User::select('users.*')
            ->join('hotel_user', 'users.id', '=', 'hotel_user.user_id')
            ->where('users.telegram_id', $telegram_id)
            ->where('hotel_user.hotel_id', $hotel_id)
            ->first();
            
        if (!$user)
            return 'Вы не подписаны на данный отель!';
        
        $user->telegram_id = null;
        $user->save();
        
        $hotel = Hotel::withoutGlobalScopes()->where('id', $hotel_id)->first();

        return sprintf('Вы отписались от уведомлений по <b>%s</b>'.PHP_EOL, $hotel->name);
    }
}
