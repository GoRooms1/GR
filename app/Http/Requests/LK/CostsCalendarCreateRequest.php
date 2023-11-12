<?php

namespace App\Http\Requests\LK;

use Auth;
use DB;
use Illuminate\Foundation\Http\FormRequest;

class CostsCalendarCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {        
        $checkedUser = DB::table('users')
            ->join('hotel_user','users.id','=','hotel_user.user_id')
            ->join('hotels','hotel_user.hotel_id','=','hotels.id')
            ->join('rooms','hotels.id','=','rooms.hotel_id')
            ->join('costs','rooms.id','=','costs.room_id')
            ->where('costs.id', $this->get('cost_id', 0))
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
        return [
            'cost_id'=> ['required', 'exists:costs,id'],
            'value'=> ['required', 'numeric', 'min:0'],
            'date_from' => ['required', 'date', 'after_or_equal:'.Date('Y-m-d')],
            'date_to' => ['required', 'date', 'after_or_equal:'.Date('Y-m-d'), 'after_or_equal:date_from'],
        ];
    }
}
