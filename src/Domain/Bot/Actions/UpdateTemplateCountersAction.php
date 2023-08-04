<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use App\User;
use Domain\Bot\Models\BotMessageTemplate;
use Lorisleiva\Actions\Action;

/**
 * @method static BotMessageTemplate run(BotMessageTemplate $template, int $hotel_id = 0)
 */
final class UpdateTemplateCountersAction extends Action
{
    public function handle(BotMessageTemplate $template, int $hotel_id = 0): BotMessageTemplate
    {  
        $users_count = User::select('users.telegram_id')
            ->distinct('users.telegram_id')
            ->withoutGlobalScopes()
            ->join('hotel_user', 'users.id', '=', 'hotel_user.user_id')                     
            ->when($hotel_id > 0, function($q) use ($hotel_id) {
                $q->where('hotel_user.hotel_id', $hotel_id);
            })
            ->whereNotNull('users.telegram_id')
            ->count();
        
        $hotels_count = User::select('hotel_user.hotel_id')
            ->distinct('hotel_user.hotel_id')
            ->withoutGlobalScopes()
            ->join('hotel_user', 'users.id', '=', 'hotel_user.user_id')                     
            ->when($hotel_id > 0, function($q) use ($hotel_id) {
                $q->where('hotel_user.hotel_id', $hotel_id);
            })
            ->whereNotNull('users.telegram_id')
            ->count();

        $template->users_count = $template->users_count + $users_count;
        $template->hotels_count = $template->hotels_count + $hotels_count;
        $template->save();

        return $template;
    }
}
