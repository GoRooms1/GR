<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use App\Notifications\RegisterClientFromBooking;
use App\User;
use Carbon\Carbon;
use Domain\Room\Models\Booking;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Action;

/**
 * @method static void run(Booking $booking)
 */
final class RegisterClientFromBookingAction extends Action
{
   
    public function handle(Booking $booking)
    {
        $user = User::find($booking->user_id);

        if (!$user) {
            $user = $this->register($booking);
        }

        if (!$user) {
            return;
        }

        if (!$user->register_sent_at) {
           $this->notify($user);
        }               
    }

    private function register(Booking $booking): User|null
    {
        try {
            $phone = (new ClientsPhoneNumberValueObject($booking->client_phone))->toNative();
            $password = strval(mt_rand(1000, 9999));

            $user = User::create([
                'name' => $booking->client_fio,
                'email' => $phone,
                'phone' => $phone,                
                'is_client' => true,
                'password' => Hash::make($password),
                'code' => $password,
                'notify_hot' => true,
                'notify_review' => true,
            ]);

            $booking->user_id = $user->id;
            $booking->save();

            return $user;            
        } catch (\Throwable $th) {
             \Log::error("Error while regiser client with phone ".$booking->client_phone);
        }

        return null;
    }

    private function notify($user) 
    {
        try {
            $user->notify(new RegisterClientFromBooking());
            $user->register_sent_at = Carbon::now();
            $user->save();
        } catch (\Throwable $th) {
            \Log::error("Error while sending register code to client with phone ".$user->client_phone);
        }       
    }
}
