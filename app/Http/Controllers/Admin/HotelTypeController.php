<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelTypeController extends Controller
{

    public function index(): View
    {
        $hotelTypes = HotelType::all();
        return view('admin.hotel_types.index', compact('hotelTypes'));
    }

    public function create(): View
    {
        return view('admin.hotel_types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable'],
            'sort' => ['required', 'integer', 'min:1'],
        ]);

        $hotel_type = HotelType::create($validated);

        return redirect()->route('admin.hotel_types.index')->with('success', $hotel_type->id);
    }

    public function edit(HotelType $hotelType): View
    {
        $hotelTypes = HotelType::all();
        return view('admin.hotel_types.edit', compact('hotelTypes', 'hotelType'));
    }

    public function update(Request $request, HotelType $hotelType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable'],
            'sort' => ['required', 'integer', 'min:1'],
        ]);

        $hotelType->update($validated);

        return redirect()->route('admin.hotel_types.index')->with('success', $hotelType->id);
    }

    public function destroy(HotelType $hotelType): RedirectResponse
    {
        $hotelType->delete();
        return redirect()->route('admin.hotel_types.index');
    }
}
