<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email'  => 'required|email|max:45|unique:users,email,'.$user->id,
            'phone' => 'nullable|phone',
            'password' => 'min:6|string',
            'country' => 'string',
            'city' => 'string',
            'address' => 'string',
            'postcode' => 'string',
            'role' => 'required'
        ];
    }
}
