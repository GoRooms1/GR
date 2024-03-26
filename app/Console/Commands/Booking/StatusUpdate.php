<?php

namespace App\Console\Commands\Booking;

use App\Notifications\NotificationClientForReview;
use App\User;
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
        $bookings = Booking::whereIn('status', ['wait', 'in'])
            ->whereNotNull(['from-date', 'to-date'])
            ->get();
        $now = Carbon::now(config('app.fallback_timezone'))->shiftTimezone(config('app.timezone'));
        
        foreach ($bookings as $booking) {           
            if ($booking['to-date']->lessThan($now)) {
                $booking->status = 'out';
                $booking->save();

                $this->notifyClientForReview($booking);

                continue;
            }

            if ($booking['from-date']->lessThan($now)) {
                $booking->status = 'in';
                $booking->save();
                continue;
            }           
        }
    }

    private function notifyClientForReview(Booking $booking)
    {
        if (!$booking->user_id) {
            return;
        }
       
        try {
            $user = User::find($booking->user_id);

            if ($user->notify_review) {
                $user->notify(new NotificationClientForReview($booking));
            }
        } catch (\Throwable $th) {
            \Log::error("Error in client notification for review. Booking #".$booking->book_number);
        }
    }
}
