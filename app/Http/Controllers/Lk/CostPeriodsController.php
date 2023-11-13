<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Http\Requests\LK\CostPeriodCreateRequest;
use App\Http\Requests\LK\CostPeriodDeleteRequest;
use App\Http\Requests\LK\CostPeriodGetAllRequest;
use Domain\Room\Actions\CreateCostPeriodAction;
use Domain\Room\Actions\GetCostPeriodsByCostIdAction;
use Domain\Room\Models\CostPeriod;
use Illuminate\Http\JsonResponse;

class CostPeriodsController extends Controller
{
    public function getCostPeriodsByCostId(int $id, CostPeriodGetAllRequest $request): JsonResponse
    {
        return response()->json(['costPeriods' => GetCostPeriodsByCostIdAction::run($id)]);
    }

    public function create(CostPeriodCreateRequest $request): JsonResponse
    {
        $costPeriod = CreateCostPeriodAction::run($request->all());

        return response()->json(['costPeriods' => GetCostPeriodsByCostIdAction::run($costPeriod->cost_id)]);
    }

    public function destroy(int $id, CostPeriodDeleteRequest $request): JsonResponse
    {        
        $costPeriod = CostPeriod::findOrFail($id);
        $costPeriod->is_active = false;
        $costPeriod->save();

        return response()->json(['costPeriods' => GetCostPeriodsByCostIdAction::run($costPeriod->cost_id)]);
    }    
}