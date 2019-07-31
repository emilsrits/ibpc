<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserActionRequest extends FormRequest
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
        return [
            'mass-action' => 'integer|in:0,1,2',
            'users' => 'nullable|array',
            'id' => 'nullable|integer',
            'user' => 'nullable|string',
            'role' => 'nullable|integer',
            'status' => 'nullable|integer',
            'createdAt' => 'nullable|string',
            'updatedAt' => 'nullable|string'
        ];
    }
}
