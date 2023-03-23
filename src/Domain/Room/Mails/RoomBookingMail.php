<?php

namespace Domain\Room\Mails;

use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public Room $room;

    public BookingData $data;

    /**
     * RoomBookingMail constructor.
     *
     * @param  Room  $room
     * @param  BookingData  $data
     */
    public function __construct(Room $room, BookingData $data)
    {
        $this->room = $room;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): RoomBookingMail
    {
        return $this->subject('Сервис GoRooms – новое бронирование '.$this->data->book_number)
            ->view('emails.room-bookin');
    }
}
