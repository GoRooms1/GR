<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use App\Notifications\RegisterClientFromBooking;
use App\User;
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
            ]);

            $user->notify(new RegisterClientFromBooking());
        } catch (\Throwable $th) {
             \Log::error("Error while regiser client with phone ".$booking->client_phone);
        }            
    }
}
