<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\LK\CostsCalendarCreateRequest;
use App\Http\Requests\LK\CostsCalendarDeleteRequest;
use App\Http\Requests\LK\CostsCalendarGetAllRequest;
use Domain\Room\Actions\CreateCostsCalendarAction;
use Domain\Room\Actions\GetCostCalendarsByCostIdAction;
use Domain\Room\Models\CostsCalendar;
use Illuminate\Http\JsonResponse;

class CostsCalendarController extends Controller
{
    public function getCostsCalendarByCostId(int $id, CostsCalendarGetAllRequest $request): JsonResponse
    {
        return response()->json(['costsCalendars' => GetCostCalendarsByCostIdAction::run($id)]);
    }

    public function create(CostsCalendarCreateRequest $request): JsonResponse
    {
        $costCalendar = CreateCostsCalendarAction::run($request->all());

        return response()->json(['costsCalendars' => GetCostCalendarsByCostIdAction::run($costCalendar->cost_id)]);
    }

    public function destroy(int $id, CostsCalendarDeleteRequest $request): JsonResponse
    {        
        $costCalendar = CostsCalendar::findOrFail($id);
        $costCalendar->is_active = false;
        $costCalendar->save();

        return response()->json(['costsCalendars' => GetCostCalendarsByCostIdAction::run($costCalendar->cost_id)]);
    }    
}
