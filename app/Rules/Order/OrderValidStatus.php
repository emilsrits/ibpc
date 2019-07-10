<?php

namespace App\Rules\Order;

use Illuminate\Contracts\Validation\Rule;

class OrderValidStatus implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $property
     * @param  mixed  $value
     * @return bool
     */
    public function passes($property, $value)
    {
        return orderStatusExists($value) || $value == (string)0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid order status!';
    }
}
