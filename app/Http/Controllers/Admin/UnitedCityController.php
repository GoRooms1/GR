<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitedCity;
use DB;
use Domain\Address\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UnitedCityController extends Controller
{
    public function index()
    {
        $unitedCities = UnitedCity::all();

        return view('admin.united-cities.index', compact('unitedCities'));
    }

    public function create()
    {
        $cities = Address::orderBy('city')->pluck('city')->unique();

        return view('admin.united-cities.create', compact('cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:united_cities,name',
            'description' => 'nullable',
            'cities' => 'required|array',
            'cities.*' => 'required|string|exists:addresses,city',
        ]);

        $united = new UnitedCity();
        $united->name = $request->get('name');
        $united->description = null;
        $united->save();

        foreach ($request->get('cities') as $item) {
            $table = DB::table('united_cities_address');
            $table->insert([
                'united_city' => $united->id,
                'city_name' => $item,
            ]);
        }

        return redirect()->route('admin.united_cities.index');
    }

    public function edit(int $id)
    {
        $united = UnitedCity::findOrFail($id);
        $cities = Address::orderBy('city')->pluck('city')->unique();

        return view('admin.united-cities.edit', compact('united', 'cities'));
    }

    public function update(Request $request, int $id)
    {
        $united = UnitedCity::findOrFail($id);
        $request->validate([
            'name' => 'required|string|unique:united_cities,name,'.$id,
            'description' => 'nullable',
            'cities' => 'required|array',
            'cities.*' => 'required|string|exists:addresses,city',
        ]);

        $united->update($request->all());
        $united->save();

        DB::table('united_cities_address')->where('united_city', $united->id)->delete();

        foreach ($request->get('cities') as $item) {
            $table = DB::table('united_cities_address');
            $table->insert([
                'united_city' => $united->id,
                'city_name' => $item,
            ]);
        }

        return redirect()->route('admin.united_cities.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $united = UnitedCity::findOrFail($id);
        $united->delete();

        return redirect()->route('admin.united_cities.index');
    }
}
