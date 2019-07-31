<?php

namespace App\Http\Requests\Order;

use App\Rules\Order\OrderValidStatus;
use Illuminate\Foundation\Http\FormRequest;

class OrderActionRequest extends FormRequest
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
            'mass-action' => new OrderValidStatus,
            'orders' => 'nullable|array',
            'id' => 'nullable|integer',
            'user' => 'nullable|string',
            'status' => 'nullable|string',
            'createdAt' => 'nullable|string',
            'updatedAt' => 'nullable|string'
        ];
    }
}
