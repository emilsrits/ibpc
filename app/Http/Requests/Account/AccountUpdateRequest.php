<?php

namespace App\Http\Requests\Account;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
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
            'phone' => 'regex:/^\(?\+?\(?\d{0,3}\)?\s?\d{8}$/',
            'password' => 'min:6|string|confirmed',
            'country' => 'string',
            'city' => 'string',
            'address' => 'string',
            'postcode' => 'string',
            'current_password' => 'required'
        ];
    }

    /**
     * Configure the validator instance
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!Hash::check($this->current_password, $this->user()->password)) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        });
        return;
    }
}
