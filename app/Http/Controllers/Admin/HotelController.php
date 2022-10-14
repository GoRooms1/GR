<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Models\Attribute;
use App\Models\CostType;
use App\Models\Hotel;
use App\Models\HotelType;
use App\Models\Image;
use App\Models\Metro;
use App\Models\PageDescription;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $hotels = Hotel::query();
        if ($q = $request->get('q', null)) {
            $hotels = $hotels->where('name', 'like', '%'.$q.'%');
        }
        $hotels = $hotels->paginate(15);

        return view('admin.hotel.index', compact('hotels', 'q'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HotelRequest  $request
     * @return RedirectResponse
     */
    public function store(HotelRequest $request): RedirectResponse
    {
        $request->validated();

        $hotel = new Hotel();
        $this->save($hotel, $request);

        return redirect()
          ->route('admin.hotels.index')
          ->with('success', true);
    }

    private function save(Hotel $hotel, HotelRequest $request): void
    {
        try {
            $validated = $request->validated();

            if ($request->get('slug') !== $hotel->slug) {
                PageDescription::where('url', '/hotels/'.$hotel->slug)
                  ->delete();
            }

            foreach (Hotel::getFillableData($validated) as $option => $value) {
                $hotel->$option = $value;
            }

            $hotel->save();

            if ($request->has('attributes')) {
                $hotel->attrs()
                  ->sync($validated['attributes']);
            }

            if ($request->hasFile('image')) {
                Image::upload($request, $hotel);
            }

            if ($request->has('address')) {
                $hotel->saveAddress($request->get('address', ''));
            }

            if ($request->has('address')) {
                $hotel->saveAddress($request->get('address'), $request->get('address_comment', ''));
            }

            $hotel->attachMeta($request);

            $hotel->metros()
              ->delete();
            foreach ($request->get('metros', []) as $metros) {
                if (empty($metros['name'])) {
                    continue;
                }
                $metros['hotel_id'] = $hotel->id;
                Metro::create($metros);
            }

            if ($validated['type_id']) {
                $hotel->type()
                  ->associate($validated['type_id']);
            }

            $hotel->save();
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $attributes = Attribute::where('model', Hotel::class)
          ->orWhereNull('model')
          ->get();
        $costTypes = CostType::orderBy('sort')
          ->get();
        $hotelTypes = HotelType::orderBy('sort')
          ->get();

        return view('admin.hotel.create', compact('attributes', 'costTypes', 'hotelTypes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Hotel  $hotel
     * @return View
     */
    public function show(Hotel $hotel): View
    {
        return view('admin.hotel.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Hotel  $hotel
     * @return View
     */
    public function edit(Hotel $hotel): View
    {
        $attributes = Attribute::where('model', Hotel::class)
          ->orWhereNull('model')
          ->get();
        $costTypes = CostType::orderBy('sort')
          ->get();
        $hotelTypes = HotelType::orderBy('sort')
          ->get();

        return view('admin.hotel.edit', compact('hotel', 'attributes', 'costTypes', 'hotelTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HotelRequest  $request
     * @param  Hotel  $hotel
     * @return RedirectResponse
     */
    public function update(HotelRequest $request, Hotel $hotel): RedirectResponse
    {
        $this->save($hotel, $request);

        return redirect()->route('admin.hotels.show', $hotel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Hotel  $hotel
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Hotel $hotel): RedirectResponse
    {
        $users = $hotel->users;

        $hotel->users()
          ->detach();

        $hotel->delete();

        foreach ($users as $user) {
            $user->forceDelete();
        }

        return redirect()->route('admin.hotels.index');
    }
}
