<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateReviewRequest;
use App\User;
use Domain\Review\Models\Rating;
use Domain\Review\Models\Review;
use Domain\Room\Actions\GetRoomFullNameAction;
use Domain\Room\Enums\BookingStatus;
use Domain\Room\Models\Booking;
use Domain\Room\Models\Room;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;

class ReviewController extends Controller
{
    public function create(CreateReviewRequest $request)
    {       
        $user = User::find(auth()->user()->id);
        $booking = Booking::find($request->get('booking_id'));
        $room = Room::find($booking->room_id);        
        
        if ($user->id !== $booking->user_id) {
            throw new UnauthorizedException();
        }

        if ($booking->review_id) {
            return Redirect::back()->with([
                'message' => "На данное бронирование уже был оставлен отзыв!"
            ]);
        }

        if ($user->email_verified_at == null) {           
            return Redirect::back()->with([
                'message' => "Гости с неподтверженным E-Mail адресом не могут оставлять отзывы!"
            ]);
        }

        if (!$room) {
            return Redirect::back()->with([
                'message' => "Номер был снят с публикации. К сожалению отзыв оставить нельзя."
            ]);
        }

        if ($booking->status !== BookingStatus::CheckOut->value) {
            return Redirect::back()->with([
                'message' => "Отзыв можно оставить только для бронирований со статусом \"".BookingStatus::CheckOut->trans()."\"!"
            ]);
        }
        
        $review = Review::create([
            'name' => $request->get('name'),
            'book_number' => $request->get('book_number'),
            'text' => $request->get('comment'),
            'room' => GetRoomFullNameAction::run($room),
            'user_id' => $user->id,
            'room_id' => $room->id,
            'hotel_id' => $room->hotel_id,            
        ]);
        
        $booking->review_id = $review->id;
        $booking->save();

        if ($request->file('photo')) {
            $review->clearMediaCollection('images');
            $review->addMediaFromRequest('photo')
                ->toMediaCollection('images');
        }
       
        foreach ($request->get('rating', []) as $ratingData) {            
            $rating = new Rating();
            $rating->review_id = $review->id;
            $rating->value = $ratingData['value'];
            $rating->category_id = $ratingData['id'];
            $rating->save();            
        }

        return Redirect::back()->with([
            'message' => "Вы успешно оставили отзыв! Спасибо!"
        ]);
    }   
}
