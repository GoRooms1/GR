<?php

namespace App\Http\Controllers;

use Domain\Room\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function updateByJson(Request $request)
    {
        $new_periods = json_decode($request->result_json);
        foreach ($new_periods->for_delete as $period_id) {
            Period::find($period_id)->delete();
        }
        foreach ($new_periods->data as $period) {
            if (isset($period->id)) {
                Period::find($period->id)->update((array) $period);
            } else {
                Period::create((array) $period);
            }
        }

        return redirect()->back();
    }
}
