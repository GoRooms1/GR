<?php

namespace App\Mail;

use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $room;
    public $fields;

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
    public function build()
    {
        return $this->subject('Забронирован номер ' . $this->room->name)
            ->view('emails.room-bookin');
    }
}
