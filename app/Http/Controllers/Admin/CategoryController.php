<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function index()
    {
        //
    }

    public function create(Hotel $hotel): View
    {
        return view('admin.category.create', compact('hotel'));
    }

    public function store(CategoryRequest $request, Hotel $hotel): RedirectResponse
    {
        $validated = $request->validated();
        $validated['hotel_id'] = $hotel->id;
        $category = Category::create($validated);
        return redirect()->route('admin.hotels.show', $category->hotel);
    }

    public function edit(Hotel $hotel, Category $category): View
    {
        return view('admin.category.edit', compact('category', 'hotel'));
    }

    public function update(CategoryRequest $request, Hotel $hotel, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        $category->update($validated);
        return redirect()->route('admin.hotels.show', $hotel);
    }

    public function destroy(Hotel $hotel, Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.hotels.show', $hotel);
    }
}
