<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostType;
use App\Models\FilterCost;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuCostsController extends Controller
{
    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $costTypes = CostType::with('filterCosts')->get();

        return view('admin.settings.menu-costs.index',
            compact(
                'costTypes'
            )
        );
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|array',
            'type.*' => 'required|array',
            'type.*.*' => 'required|integer',
        ]);

        $data = $request->all();
        $types = $data['type'];
//    dd($types);

        foreach ($types as $id => $type) {
            $costType = CostType::find((int) $id);
            $costType->filterCosts()->delete();
            foreach ($type as $cost) {
                $filterCost = new FilterCost([
                    'cost' => $cost,
                ]);
                $filterCost->costType()->associate($costType);
                $filterCost->save();
            }
        }

        return redirect()->back();
    }
}
