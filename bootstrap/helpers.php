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

if (!function_exists('sessionOldCart')) {
    /**
     * Get the previous cart instance
     * 
     * @return Cart|null
     */
    function sessionOldCart()
    {
        return Session::has('cart') ? Session::get('cart') : null;
    }
}

if (!function_exists('countryFromCode')) {
    /**
     * Return country based on its code
     * 
     * @param string $code
     * @return string|null
     */
    function countryFromCode(string $code)
    {
        $countries = config('constants.countries');
        
        if (isset($countries[$code])) {
            return $countries[$code];
        } else {
            return null;
        }
    }
}

if (!function_exists('sortEntry')) {
    /**
     * Return the next direction of sorting entry
     * 
     * @param string|null $entry
     * @return string|null
     */
    function sortEntry($entry = null) {
        switch ($entry) {
            case null:
                return 'desc';
            case 'desc':
                return 'asc';
            default:
                return null;
        }
    }
}