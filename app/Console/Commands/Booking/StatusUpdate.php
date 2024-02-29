<?php

namespace App\Console\Commands\Booking;

use Carbon\Carbon;
use DateTimeZone;
use Domain\Room\Enums\BookingStatus;
use Domain\Room\Models\Booking;
use Illuminate\Console\Command;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:status-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status for bookings';

    /**
     * Execute the console command. 
     * @return void
     */
    public function handle()
    {      
        $bookings = Booking::whereIn('status', [BookingStatus::Wait, BookingStatus::StayinAtHotel])
            ->whereNotNull(['from-date', 'to-date'])
            ->get();
        $now = Carbon::now('Europe/Moscow')->shiftTimezone(config('app.timezone'));
        
        foreach ($bookings as $booking) {           
            if ($booking['to-date']->lessThan($now)) {
                $booking->status = BookingStatus::CheckOut;
                $booking->save();
                continue;
            }

            if ($booking['from-date']->lessThan($now)) {
                $booking->status = BookingStatus::StayinAtHotel;
                $booking->save();
                continue;
            }           
        }
    }
}
