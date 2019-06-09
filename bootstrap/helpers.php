<?php

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
|
| This file contains helper functions that can be used across the app.
|
*/

if (!function_exists('validStatus')) {
    /**
     * Check if status is valid, defined in config
     *
     * @param string $status
     * @return bool
     */
    function validStatus(string $status)
    {
        if (!in_array($status, config('constants.order_status'))) {
            return false;
        }
        return true;
    }
}