<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Notifications\NotificationHotelBookingCanceled;
use App\User;
use Domain\Hotel\Actions\GetHotelUsersAction;
use Domain\Review\Actions\GetRatingCategories;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Booking;
use Domain\User\DataTransferObjects\ClientUserData;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;

class BookingsController extends Controller
{
    public function index(): Response | ResponseFactory
    {        
        return Inertia::render('Client/Bookings', [
            'bookings' => BookingData::collection(Booking::with('room')->where('user_id', auth()->user()->id)->get()),
            'rating_categories' => GetRatingCategories::run(),
            'user' => ClientUserData::fromModel(User::findOrFail(auth()->user()->id)),
        ]);
    }

    public function cancel(Booking $booking)
    {
        $user = User::find(auth()->user()->id);
        
        if ($user->id !== $booking->user_id) {
            throw new UnauthorizedException();
        }

        if ($booking->status === 'ch') {
            return Redirect::back()->with(['message' => 'Бронирование уже отменено отелем!']);
        }

        $booking->status = 'cc';
        $booking->save();

        $hoteliers = GetHotelUsersAction::run($booking->room->hotel_id);            
        foreach ($hoteliers as $hotelier) {            
            try {
                $hotelier->notify(new NotificationHotelBookingCanceled($booking));
            } catch (\Throwable $th) {
                \Log::error('Book cancel notification error. Book #'.$booking.'. User Email '.$hotelier->email);
            }
        }        

        return Redirect::back()->with(['message' => 'Бронирование отменено!']);
    }
}
