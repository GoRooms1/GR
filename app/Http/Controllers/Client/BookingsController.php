<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\User;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Models\Booking;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index(): Response | ResponseFactory
    {        
        return Inertia::render('Client/Bookings', [
            'bookings' => BookingData::collection(Booking::with('room')->where('user_id', auth()->user()->id)->get()),
        ]);
    }    
}
