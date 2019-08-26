<?php

return [
    // App name
    'app' => [
        'name' => env('APP_NAME')
    ],

    // Admin seed
    'admin' => [
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD')
    ],

    // Default pagination limit
    'pagination' => [
        'limit' => 20,
    ],

    // Save a copy of invoice inside storage directory
    'invoice_storage' => false,

    // Displayed currency in mail, PDF templates
    'currency' => 'EUR',

    // Delivery cost
    'delivery_cost' => [
        'storage' => 0,
        'address' => 699
    ],

    // User roles
    'user_roles' => [
        'admin' => '1',
        'user' => '2'
    ],

    // Order statuses
    'order_status' => [
        'canceled'  => 'canceled',
        'pending'   => 'pending',
        'invoiced'  => 'invoiced',
        'paid'      => 'paid',
        'shipped'   => 'shipped',
        'completed' => 'completed'
    ],

    // Order statuses for active orders
    'order_status_active' => [
        'pending'   => 'pending',
        'invoiced'  => 'invoiced',
        'paid'      => 'paid',
        'shipped'   => 'shipped'
    ],

    // Order statuses for finished orders
    'order_status_finished' => [
        'canceled'  => 'canceled',
        'completed' => 'completed'
    ],

    // Recipient info
    'recipient' => [
        'name'      => 'Example',
        'id'        => 1234567890,
        'reg'       => 987654321231,
        'address'   => 'Example',
        'bank'      => 'Testbank',
        'code'      => '90876504321',
        'account'   => 'RND0M123'
    ],

    // Array with supported countries
    'countries' => [
        '0' => 'Select a Country',
        'AT' => 'Austria',
        'BE' => 'Belgium',
        'BG' => 'Bulgaria',
        'HR' => 'Croatia',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'EE' => 'Estonia',
        'FI' => 'Finland',
        'FR' => 'France',
        'DE' => 'Germany',
        'GR' => 'Greece',
        'HU' => 'Hungary',
        'IE' => 'Ireland',
        'IT' => 'Italy',
        'LV' => 'Latvia',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MT' => 'Malta',
        'NL' => 'Netherlands',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'RO' => 'Romania',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'ES' => 'Spain',
        'SE' => 'Sweden',
        'GB' => 'United Kingdom'
    ]
];