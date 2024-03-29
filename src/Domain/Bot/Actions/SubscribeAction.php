<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use App\User;
use Domain\Hotel\Models\Hotel;
use Illuminate\Support\Facades\Redis;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(int $hotel_id, string $phone, string $pass, int $telegram_id)
 */
final class SubscribeAction extends Action
{
    public function handle(int $hotel_id, string $phone, string $pass, int $telegram_id): string
    {        
        $user = User::select('users.*')
            ->join('hotel_user', 'users.id', '=', 'hotel_user.user_id')
            ->whereRaw("REGEXP_REPLACE(phone, '[^0-9]', '') = '".preg_replace('/\D/', '', $phone)."'")
            ->where('hotel_user.hotel_id', $hotel_id)
            ->first();

        if (!$user)
            return 'Во время подписки произошла ошибка! Попробуйте начать заново с команды /sub';

        if (!password_verify($pass, $user->password))
            return 'Неверный пароль!';
        
        $user->telegram_id = $telegram_id;
        $user->save();
        
        $hotel = Hotel::withoutGlobalScopes()->where('id', $hotel_id)->first();
        Redis::del('bot:'.$telegram_id.':sub');

        return sprintf('Вы успешно подписались на уведомления отеля <b>%s</b>'.PHP_EOL, $hotel->name);
    }
}
