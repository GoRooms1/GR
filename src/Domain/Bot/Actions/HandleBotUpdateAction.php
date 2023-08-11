<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use App\User;
use Domain\Bot\DataTransferObjects\SubscribeData;
use Domain\Hotel\Models\Hotel;
use Illuminate\Support\Facades\Redis;
use Lorisleiva\Actions\Action;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

/**
 * @method static void run(Update|array $update)
 */
final class HandleBotUpdateAction extends Action
{
    public function handle(Update|array $update)
    {  
        $telegram_id = intval($update->getMessage()->from->id);
        $message = strval($update->getMessage()->text);

        if (empty($message))
            return;

        if (Redis::exists('bot:'.$telegram_id.':sub'))
            $this->handleSubscribe($telegram_id, $message);
    }

    private function handleSubscribe(int $telegram_id, string|null $message) 
    {
        $key = 'bot:'.$telegram_id.':sub';
        $subscribeData = SubscribeData::from(json_decode(Redis::get($key), true));

        \Log::info($subscribeData);

        //Fill hotel_id
        if ($subscribeData->hotel_id === null) {
            $hotel = Hotel::withoutGlobalScopes()->find($message);

            if (!$hotel) {
                Telegram::sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => 'Не нашел Ваш отель в нашей базе, уточните ID или зарегистрируйте объект.',
                ]);

                return;
            }

            $subscribeData->hotel_id = $hotel->id;
            Redis::set($key, $subscribeData->toJson());

            Telegram::sendMessage([
                'chat_id' => $telegram_id,
                'text' => 'Узнал Ваш отель, теперь укажите Ваш номер телефона:',
            ]);

            return;
        }

        //Fill phone
        if ($subscribeData->hotel_id !== null && $subscribeData->phone === null) {
            $phone = preg_replace('/\D/', '', $message);
            $user = User::select('users.*')
                ->join('hotel_user', 'users.id', '=', 'hotel_user.user_id')
                ->whereRaw("REGEXP_REPLACE(phone, '[^0-9]', '') = '".$phone."'")
                ->where('hotel_user.hotel_id', $subscribeData->hotel_id)
                ->first();

            if (!$user) {
                Telegram::sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => 'Номер телефона не найден. Пожалуйста, уточните Ваши данные в Личном кабинете отеля.',
                ]);

                return;
            }

            $subscribeData->phone = $phone;
            Redis::set($key, $subscribeData->toJson());

            Telegram::sendMessage([
                'chat_id' => $telegram_id,
                'text' => 'Здравствуйте, '.$user->name.'! Введите пароль:',
            ]);

            return;
        }

        //Subscribe
        if ($subscribeData->hotel_id !== null && $subscribeData->phone !== null) {           
            Telegram::sendMessage([
                'chat_id' => $telegram_id,
                'text' => SubscribeAction::run($subscribeData->hotel_id, $subscribeData->phone, $message, $telegram_id),
                'parse_mode' => 'html',
            ]);
        }
    }
}
