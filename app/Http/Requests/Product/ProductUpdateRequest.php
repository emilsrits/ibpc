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
        $id = $this->route('id');

        return [
            'image' => 'nullable|file',
            'code' => 'required|string|unique:products,code,'.$id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|regex:/^[0-9][0-9]*$/',
            'status' => 'required|integer|in:0,1',
            'attr' => 'nullable'
        ];
    }
}
