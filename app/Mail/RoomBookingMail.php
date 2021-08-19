<?php

namespace App\Mail;

use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public Room $room;
    public array $fields;

    /**
     * RoomBookingMail constructor.
     * @param Room $room
     * @param array $fields
     */
    public function __construct(Room $room, array $fields)
    {
        $this->room = $room;
        $this->fields = $fields;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): RoomBookingMail
    {
        return $this->subject('Сервис GoRooms – новое бронирование ' . $this->fields['book_number'])
            ->view('emails.room-bookin');
    }
}
