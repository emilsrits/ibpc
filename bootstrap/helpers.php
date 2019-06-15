<?php

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
|
| This file contains helper functions that can be used across the app.
|
*/

if (!function_exists('orderStatusExists')) {
    /**
     * Check if order status is valid, defined in config
     *
     * @param string $status
     * @return bool
     */
    function orderStatusExists(string $status)
    {
        if (!in_array($status, config('constants.order_status'))) {
            return false;
        }
        return true;
    }
}

if (!function_exists('orderStatusFinished')) {
    /**
     * Check if order status is finished
     *
     * @param string $status
     * @return bool
     */
    function orderStatusFinished(string $status)
    {
        if (!in_array($status, config('constants.order_status_finished'))) {
            return false;
        }
        return true;
    }
}