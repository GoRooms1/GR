<?php

namespace App\Http\Requests\LK;

use App\Models\Metro;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
      $array = [
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string'],
        'position' => ['required', 'string', 'max:255'],
        'code' => ['required', 'string', 'max:255']
      ];

      if ($this->routeIs('lk.staff.create')) {
        $createArray =[
          'hotel_position' => ['required', 'string', 'in:' . implode(',', User::POSITIONS)],
          'email' => ['required', 'string', 'unique:users,email'],
          'password' => ['required', 'string'],
        ];

        return array_merge($array, $createArray);
      }

      return [

      ];
    }
}
