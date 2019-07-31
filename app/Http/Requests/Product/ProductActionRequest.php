<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductActionRequest extends FormRequest
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
            'mass-action' => 'integer|in:0,1,2,3',
            'catalog' => 'nullable|array',
            'id' => 'nullable|integer',
            'title' => 'nullable|string',
            'code' => 'nullable|string',
            'status' => 'nullable|string',
            'category' => 'nullable|string',
            'createdAt' => 'nullable|string',
            'updatedAt' => 'nullable|string'
        ];
    }
}
