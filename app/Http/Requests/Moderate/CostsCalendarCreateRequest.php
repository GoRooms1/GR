<?php

namespace App\Http\Requests\Moderate;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {        
        if ($this->routeIs('*.cost-calendar.create')) {
           return [
            'cost_id'=> ['required', 'exists:costs,id'],
            'value'=> ['required', 'numeric', 'min:0'],
            'date_from' => ['required', 'date'],
            'date_to' => ['required', 'date'],
           ];
        }

        return [];
    }
}
