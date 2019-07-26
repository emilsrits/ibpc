<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
        $product = $this->route('product');

        return [
            'submit' => 'required',
            'media' => 'nullable',
            'media.*' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'code' => 'required|string|unique:products,code,'.$product->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|regex:/^[0-9][0-9]*$/',
            'status' => 'required|integer|in:0,1',
            'properties' => 'nullable'
        ];
    }
}
