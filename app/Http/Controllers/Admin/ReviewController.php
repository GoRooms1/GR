<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use Domain\Review\Models\RatingCategory;
use Domain\Hotel\Models\Hotel;
use Domain\Review\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Hotel $hotel): View
    {
        return view('admin.reviews.index', compact('hotel'));
    }

    public function create(Hotel $hotel): View
    {
        $categories = RatingCategory::orderBy('sort')->get();

        return view('admin.reviews.create', compact('hotel', 'categories'));
    }

    public function store(ReviewRequest $request, Hotel $hotel): RedirectResponse
    {
        $validated = $request->validated();
        $validated['hotel_id'] = $hotel->id;
        $review = Review::create(Review::getFillableData($validated));
        foreach ($validated['rating'] as $rating) {
            $review->ratings()->create($rating)->save();
        }

        $review->save();

        return redirect()->route('admin.reviews.index', $hotel);
    }

    public function edit(Hotel $hotel, Review $review): View
    {
        $categories = RatingCategory::orderBy('sort')->get();

        return view('admin.reviews.edit', compact('review', 'hotel', 'categories'));
    }

    public function update(ReviewRequest $request, Hotel $hotel, Review $review): RedirectResponse
    {
        if ($review->hotel->id !== $hotel->id) {
            return redirect()->back()->withErrors('hotel', 'Not actually hotel');
        }

        $validated = $request->validated();

        foreach ($validated['rating'] as $rating) {
            $review->ratings()->updateOrInsert(['category_id' => $rating['category_id']], $rating);
        }

        $review->save(Review::getFillableData($validated));

        return redirect()->route('admin.reviews.index', $hotel);
    }

    public function destroy(Hotel $hotel, Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index', $hotel);
    }
}
