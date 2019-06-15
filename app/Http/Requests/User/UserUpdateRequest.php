<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\User\UserValidUpdate;

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
        $id = $this->route('id');

        return [
            'submit' => new UserValidUpdate,
            'name' => 'required|max:20',
            'surname' => 'required|max:20',
            'email'  => 'required|email|max:25|unique:users,email,'.$id,
            'phone' => 'regex:/^\(?\+?\(?\d{0,3}\)?\s?\d{8}$/',
            'password' => 'min:6|string',
            'country' => 'string',
            'city' => 'string',
            'address' => 'string',
            'postcode' => 'string',
            'role' => 'required'
        ];
    }
}
