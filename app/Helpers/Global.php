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
    function arrayExclude(array $array, array $excludedKeys)
    {
        foreach($excludedKeys as $key){
            unset($array[$key]);
        }
        return $array;
    }
}

if (!function_exists('intermediateSyncArray')) {
    /**
     * Create array with intermediate values ready for relationship syncing
     *
     * @param array $array
     * @return Collection
     */
    function intermediateSyncArray(array $array)
    {
        $collection = collect($array)->mapWithKeys(function($item, $key) {
            return [
                key($item) => [
                    'value' => $item[key($item)]
                ]
            ];
        });

        return $collection;
    }
}

if (!function_exists('parseMoneyByDecimal')) {
    /**
     * Parse money by decimal type
     *
     * @param string $money
     * @return string
     */
    function parseMoneyByDecimal($money)
    {
        $parsed = money_parse_by_decimal($money, config('constants.currency'))->toArray();

        return $parsed['amount'];
    }
}

if (!function_exists('formatMoneyByDecimal')) {
    /**
     * Format money by decimal type
     *
     * @param string $money
     * @return string
     */
    function formatMoneyByDecimal($money)
    {
        $formatted = money($money)->formatByDecimal();

        return $formatted;
    }
}

if (!function_exists('arrayFromCollection')) {
    /**
     * Create associative array from collection with key and value based on model attribute
     *
     * @param $collection
     * @param string $key
     * @param string $value
     * @return array
     */
    function arrayFromCollection($collection, $key, $value)
    {
        $array = [];

        foreach($collection as $item) {
            $array[$item[$key]] = $item[$value];
        }

        return $array;
    }
}
