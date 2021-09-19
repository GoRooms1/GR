<?php

namespace App\Http\Requests\LK;

use App\Models\Metro;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 */

class StaffRequest extends FormRequest
{
  /**
   * @var mixed
   */

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
        $create_array =[
          'hotel_position' => ['required', 'string', 'in:' . implode(',', User::POSITIONS)],
          'email' => ['required', 'string', 'unique:users,email'],
          'password' => ['required', 'string'],
        ];

        return array_merge($array, $create_array);
      }

      if ($this->routeIs('lk.staff.update')) {
        $update_array =[
          'email' => ['required', 'string', 'unique:users,email,' . $this->id],
          'password' => ['nullable', 'string'],
        ];

        return array_merge($array, $update_array);
      }

      return [

      ];
    }
}