<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moderate\UpdateReviewRequest;
use Cache;
use Domain\Hotel\Models\Hotel;
use Domain\Review\Models\Rating;
use Domain\Review\Models\RatingCategory;
use Domain\Review\Models\Review;
use Domain\Room\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReviewController extends Controller
{
    
    public function index(int $id)
    {        
        $hotel = Hotel::find($id);
        $reviews = Review::where('hotel_id', $id)->orderBy('created_at', 'desc')->paginate(20);

        return view('moderator.reviews.index', compact('reviews', 'hotel'));
    }

    public function edit(Request $request, Review $review)
    {
        $hotel = Hotel::find($review->hotel_id);
        return view('moderator.reviews.edit', compact('review', 'hotel'));
    }
    public function update(UpdateReviewRequest $request, Review $review)
    {       
        $review->update([
            'name' => $request->get('name'),            
            'text' => $request->get('comment'),           
        ]);

        if ($request->file('photo')) {
            $review->clearMediaCollection('images');
            $review->addMediaFromRequest('photo')
                ->toMediaCollection('images');
        }
       
        foreach ($request->get('rating', []) as $key => $value) {            
            $rating = Rating::where('review_id', $review->id)
                ->where('category_id', $key)
                ->first();

            if (RatingCategory::find($key) === null) {
                continue;
            }

            if ($rating === null) {
                $rating = new Rating();
                $rating->review_id = $review->id;
                $rating->category_id = $key;
            }
            
            $rating->value = $value;
            
            $rating->save();            
        }

        Cache::flush();

        return redirect()->back()->with(["message" => "Отзыв успешно сохранен!"]);
    }

    public function delete(Review $review)
    {
        $hotel = Hotel::find($review->hotel_id);
        $review->delete();
        Cache::flush();
        
        return redirect()->route('moderator.reviews.index', $hotel->id);
    }
}
