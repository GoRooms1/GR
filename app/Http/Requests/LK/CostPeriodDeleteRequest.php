<?php

namespace App\Http\Requests\LK;

use Auth;
use DB;
use Domain\Room\Models\CostPeriod;
use Illuminate\Foundation\Http\FormRequest;

class CostPeriodDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $costPeriod = CostPeriod::where('id', $this->route('id'))->first();

        if (!$costPeriod)
            return false;

        $checkedUser = DB::table('users')
            ->join('hotel_user','users.id','=','hotel_user.user_id')
            ->join('hotels','hotel_user.hotel_id','=','hotels.id')
            ->join('rooms','hotels.id','=','rooms.hotel_id')
            ->join('costs','rooms.id','=','costs.room_id')
            ->where('costs.id', $costPeriod->cost_id)
            ->where('users.id', Auth::user()->id)
            ->get();

        if (count($checkedUser) > 0)
            return true;

        return false;      
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {        
        return [];
    }
}
