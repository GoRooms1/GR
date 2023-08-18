<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use Domain\Bot\DataTransferObjects\BotMessageData;
use Domain\Bot\Jobs\BotNotificationJob;
use Domain\Bot\Models\BotMessageTemplate;
use Domain\Room\Models\Booking;
use Domain\Room\Models\Room;
use Lorisleiva\Actions\Action;

/**
 * @method static void run(int $hotel_id)
 */
final class BotMessageTeplatesDispatchAction extends Action
{
    public function handle(int $hotel_id)
    {        
        $bookingsCount = Booking::whereIn('room_id', Room::where('hotel_id', $hotel_id)->pluck('id'))->count();
        $templates = BotMessageTemplate::where('is_active', true)->get();

        foreach ($templates as $template) {
            $frequency = $template->frequency > 0 ? $template->frequency : 1;
            $is_allow_send = intdiv($bookingsCount, $frequency) == $bookingsCount/$frequency;            
            
            if (!$is_allow_send)
                continue;

            $users = GetSubscribedUsersOnHotelAction::run($hotel_id);
            $text = GenerateTextFromTemplateAction::run($template);

            foreach ($users as $user) {
                $message = new BotMessageData(
                    chat_id: $user->telegram_id,
                    text: $text,
                    parse_mode: 'markdown',
                    disable_web_page_preview: false,
                  );
                
                BotNotificationJob::dispatch($message)->onQueue(null)->delay(now()->addSeconds(config('telegram.job_delay')));                
            }

            UpdateTemplateCountersAction::run($template, $hotel_id);
        }
    }
}
