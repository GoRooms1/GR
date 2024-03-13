<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\LK\BookingUpdateRequest;
use Auth;
use Domain\Room\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $hotel = Auth::user()->personal_hotel;

        $q_name = $request->get('q_name');
        $q_phone = $request->get('q_phone');
        $q_date = $request->get('q_date');
        $q_number = $request->get('q_number');       
        $q_date_from = $request->get('q_date_from');
        $q_status = $request->get('q_status');
        
        $bookings = Booking::with(['room', 'room.hotel'])
            ->when($q_name, function ($q) use ($q_name) {
                $q->where('client_fio', 'like', '%'.$q_name.'%');
            })
            ->when($q_phone, function ($q) use ($q_phone) {
                $q->where('client_phone', 'like', '%'.$q_phone.'%');
            })
            ->when($q_date, function ($q) use ($q_date) {
                $q->whereDate('created_at', '=', $q_date);
            })
            ->when($q_date_from, function ($q) use ($q_date_from) {
                $q->whereDate('from-date', '=', $q_date_from);
            })
            ->when($q_number, function ($q) use ($q_number) {
                $q->where('book_number', 'like', '%'.$q_number.'%');
            })
            ->when($q_status, function ($q) use ($q_status) {
                $q->where('status', '=', $q_status);
            })            
            ->whereHas('room',  function ($q) use ($hotel) {
                $q->whereHas('hotel', function ($q) use ($hotel) {
                    $q->where('id', $hotel->id);
                });
            })
            ->orderByDesc('book_number')
            ->paginate(20);

        return view('lk.bookings.index', compact(
            'bookings',
            'hotel',
            'q_name',
            'q_phone',
            'q_date',
            'q_number',            
            'q_date_from',
            'q_status'
        ));
    }    

    public function update(BookingUpdateRequest $request, Booking $booking)
    {       
        if ($booking->room->hotel->id !== Auth::user()->personal_hotel->id) {
            throw new UnauthorizedException();
        }

        $booking->update($request->only('status'));
       
        return $request->wantsJson()
            ? response()->json(['status' => 'success'])
            : redirect(url()->previous() . "#booking_" . $booking->id);
    }
}
