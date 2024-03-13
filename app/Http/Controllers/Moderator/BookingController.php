<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, int $id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $hotel = Hotel::find($id);

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
                $q->whereRaw("REGEXP_REPLACE(client_phone, '[^0-9\+]+', '') like '%".preg_replace("/[^0-9\+]/", "", $q_phone)."%'");
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
            ->whereHas('room',  function ($q) use ($id) {
                $q->whereHas('hotel', function ($q) use ($id) {
                    $q->where('id', $id);
                });
            })
            ->orderByDesc('book_number')
            ->paginate(20);

        return view('moderator.bookings.index', compact(
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

    public function update(Request $request, Booking $booking)
    {       
        $booking->update($request->only('status'));
       
        return $request->wantsJson()
            ? response()->json(['status' => 'success'])
            : redirect(url()->previous() . "#booking_" . $booking->id);
    }
}
