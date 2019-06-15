<?php

namespace App\Http\Requests\Specification;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Specification\SpecificationValidUpdate;

class SpecificationStoreRequest extends FormRequest
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
            'submit' => new SpecificationValidUpdate,
            'slug' => 'required|string|max:20|unique:specifications,slug,'.$id,
            'name' => 'required|string|max:20'
        ];
    }
}
