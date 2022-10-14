<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $types = CostType::orderBy('sort')->get();

        return view('admin.cost_types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $last_order = CostType::getLastOrder();

        return view('admin.cost_types.create', compact('last_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable'],
            'sort' => ['required', 'integer', 'min:1'],
        ]);

        $cost_type = CostType::create($validated);

        return redirect()->route('admin.cost_types.index')->with('success', $cost_type->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CostType  $costType
     * @return View
     */
    public function edit(CostType $costType): View
    {
        return view('admin.cost_types.edit', compact('costType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CostType  $costType
     * @return RedirectResponse
     */
    public function update(Request $request, CostType $costType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable'],
            'sort' => ['required', 'integer', 'min:1'],
        ]);

        $costType->update($validated);

        return redirect()->route('admin.cost_types.index')->with('success', $costType->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CostType  $costType
     * @return RedirectResponse
     */
    public function destroy(CostType $costType): RedirectResponse
    {
        $costType->delete();

        return redirect()->route('admin.cost_types.index');
    }
}
