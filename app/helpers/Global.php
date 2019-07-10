<?php

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
     * @return mixed
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
     * @return mixed
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
     * @param mixed $entry
     * @return mixed
     */
    function sortEntry($entry = null)
    {
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

if (!function_exists('roleIdFromSlug')) {
    /**
     * Return role ID based on slug
     *
     * @param string $slug
     * @return string
     */
    function roleIdFromSlug(string $slug) {
        $roles = config('constants.user_roles');

        return $roles[$slug];
    }
}

if (!function_exists('arrayExclude')) {
    /**
     * Exclude keys from array
     *
     * @param array $array
     * @param array $excludedKeys
     * @return array
     */
    function arrayExclude(array $array, array $excludedKeys){
        foreach($excludedKeys as $key){
            unset($array[$key]);
        }
        return $array;
    }
}

if (!function_exists('intermediateSyncArray')) {
    function intermediateSyncArray(array $array) {
        $arr = collect($array)->mapWithKeys(function($item, $key) {
            return [
                key($item) => [
                    'value' => $item[key($item)]
                ]
            ];
        });

        return $arr;
    }
}