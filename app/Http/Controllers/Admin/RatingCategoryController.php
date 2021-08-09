<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RatingCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RatingCategoryController extends Controller
{
    public function index(): View
    {
        $categories = RatingCategory::all();
        return view('admin.ratings.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.ratings.create');
    }

    public function store(Request $request): View
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'numeric', 'min:1'],
        ]);

        RatingCategory::create($validated);

        return redirect()->route('admin.ratings.index');
    }

    public function edit(RatingCategory $rating): View
    {
        return view('admin.ratings.edit', compact('rating'));
    }

    public function update(Request $request, RatingCategory $rating): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'numeric', 'min:1'],
        ]);

        $rating->update($validated);

        return redirect()->route('admin.ratings.index');
    }

    public function destroy(RatingCategory $rating): RedirectResponse
    {
        $rating->delete();
        return redirect()->route('admin.ratings.index');
    }
}
