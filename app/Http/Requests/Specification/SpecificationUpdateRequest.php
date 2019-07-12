<?php

namespace App\Http\Requests\Specification;

use Illuminate\Foundation\Http\FormRequest;

class SpecificationUpdateRequest extends FormRequest
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
        $specification = $this->route('specification');

        return [
            'slug' => 'required|string|max:20|unique:specifications,slug,'.$specification->id,
            'name' => 'required|string|max:20'
        ];
    }
}
