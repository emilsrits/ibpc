<?php

return [
    // Save a copy of invoice inside storage directory
    'invoice_storage' => true,

    // Displayed currency in mail, PDF templates
    'currency' => 'EUR',

    // Delivery cost
    'delivery_cost' => [
        'storage' => 0.00,
        'address' => 6.99
    ],

    // User roles
    'user_roles' => [
        '1' => 'administrator',
        '2' => 'customer'
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
        'id'        => 435345345123453,
        'reg'       => 34535345345,
        'address'   => 'Salt Lake City, 4657 Tori Lane, 84116',
        'bank'      => 'Testbank',
        'code'      => 'TB34545',
        'account'   => 'WQ34556363464'
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