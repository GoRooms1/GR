<?php

namespace App\Jobs;

use App\Mail\RoomBookingMail;
use App\Models\Room;
use App\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BookRoomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $room_id = 0;

    protected $fields = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $room_id, array $fields)
    {
        $this->room_id = $room_id;
        $this->fields = $fields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $room = Room::findOrFail($this->room_id);
        $email = Settings::option('notify', 'gorooms@walfter.ru');
        Mail::to('GoRooms@yandex.ru')
          ->send(new RoomBookingMail($room, $this->fields));
        if ($room->hotel->email != null) {
            Mail::to($room->hotel->email)
              ->send(new RoomBookingMail($room, $this->fields));
        } else {
            Mail::to($email)
              ->send(new RoomBookingMail($room, $this->fields));
        }
    }
}
