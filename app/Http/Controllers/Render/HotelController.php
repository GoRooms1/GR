<?php

namespace App\Http\Controllers\Render;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Domain\Hotel\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::paginate(18);

        return view('render.hotel.index', compact('hotels'));
    }

    public function show(Hotel $hotel, Request $request)
    {
        $rooms = $hotel->rooms()->paginate(6);

        return view('render.hotel.show', compact('rooms', 'hotel'));
    }

    public function reviews(Hotel $hotel, Request $request)
    {
        $page = $request->get('page', 2);
        $per_page = Review::PER_PAGE;
        $skip = ($page - 1) * $per_page;
        $reviews = Review::where('hotel_id', $hotel->id)->skip($skip)->take($per_page)->get();

        return view('render.hotel.reviews', compact('reviews'));
    }
}
