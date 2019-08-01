<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $category = $this->route('category');

        return [
            'title' => 'required|string|max:20|unique:categories,title,'.$category->id,
            'top_level' => 'required|integer|in:0,1',
            'parent_id' => 'required_if:top_level,==,0|integer|regex:/^[1-9][0-9]*$/',
            'status' => 'required|integer|in:0,1',
            'spec' => 'nullable'
        ];
    }
}
