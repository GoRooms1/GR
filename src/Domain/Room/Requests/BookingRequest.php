<?php

namespace Domain\Room\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
     * @return array<string, array<string>|string>
     */
    public function rules(): array
    {
        return [
            'room_id' => ['required', 'exists:rooms,id'],
            'client_fio' => ['required', 'string', 'min:3', 'max:190'],
            'client_phone' => ['required', 'phone:RU'],
            'from_date' => ['required', 'date'],
            'from_time' => ['required', 'string'],
            'to_date' => ['required', 'date'],
            'to_time' => ['required', 'string'],
            'comment' => ['nullable'],
            'book_type' => ['required', 'string'],
            'hours_count' => ['nullable', 'int'],
        ];
    }
}
