<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Domain\Address\Models\Address;
use Domain\Address\Models\RegionalCenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionalCenterController extends Controller
{
    public function index(): View
    {
        $regionalCenters = RegionalCenter::all();

        return view('admin.regional_centers.index', compact('regionalCenters'));
    }

    public function create(): View
    {
        $cities = Address::distinct('city')->whereNotNull('city')->orderBy('city')->pluck('city');
        $regions = Address::distinct('region')->whereNotNull('region')->orderBy('region')->pluck('region');

        return view('admin.regional_centers.create', compact('cities', 'regions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string'],
            'region' => ['required', 'string'],
        ]);

        $regionalCenter = RegionalCenter::create($validated);

        return redirect()->route('admin.regional_centers.index')->with('success', $regionalCenter->id);
    }

    public function edit(RegionalCenter $regionalCenter): View
    { 
        $cities = Address::distinct('city')->whereNotNull('city')->orderBy('city')->pluck('city');
        $regions = Address::distinct('region')->whereNotNull('region')->orderBy('region')->pluck('region');

        return view('admin.regional_centers.edit', compact('cities', 'regions', 'regionalCenter'));
    }

    public function update(Request $request, RegionalCenter $regionalCenter): RedirectResponse
    {
        $validated = $request->validate([
            'city' => ['required', 'string'],
            'region' => ['required', 'string'],
        ]);

        $regionalCenter->update($validated);

        return redirect()->route('admin.regional_centers.index')->with('success', $regionalCenter->id);
    }

    public function destroy(RegionalCenter $regionalCenter): RedirectResponse
    {
        $regionalCenter->delete();

        return redirect()->route('admin.regional_centers.index');
    }
}
