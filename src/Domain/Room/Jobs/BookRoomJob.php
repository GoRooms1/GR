<?php

namespace Domain\Room\Jobs;

use Domain\Bot\Actions\BotMessageTeplatesDispatchAction;
use Domain\Bot\Actions\GetSubscribedUsersOnHotelAction;
use Domain\Bot\DataTransferObjects\BotMessageData;
use Domain\Bot\Jobs\BotNotificationJob;
use Domain\Room\Actions\GenerateBookingBotNotificationTextAction;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Mails\RoomBookingMail;
use Domain\Room\Models\Room;
use Domain\Settings\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BookRoomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BookingData $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BookingData $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $room = Room::findOrFail($this->data->room_id);

        //Mail notification  
        $email = Settings::option('notify', 'gorooms@walfter.ru');     
        Mail::to('GoRooms@yandex.ru')
          ->send(new RoomBookingMail($room, $this->data));
        if ($room->hotel->email != null) {
            Mail::to($room->hotel->email)
              ->send(new RoomBookingMail($room, $this->data));
        } else {
            Mail::to($email)
              ->send(new RoomBookingMail($room, $this->data));
        }
        
        //Telegram notification
        try {
          $users = GetSubscribedUsersOnHotelAction::run($room->hotel_id);
          $text = GenerateBookingBotNotificationTextAction::run($this->data);

          foreach ($users as $user) {
            $message = new BotMessageData(
              chat_id: $user->telegram_id,
              text: $text,
            );

            BotNotificationJob::dispatch($message);
          }
          
        } catch (\Exception $e) {
          \Log::error($e);
        }

        //Dispatch bot notifications from bot
        BotMessageTeplatesDispatchAction::run($room->hotel_id);
    }
}
