<?php

return [
    // Save a copy of invoice inside storage directory
    'invoice_storage' => true,

    // Displayed currency in mail, PDF templates
    'currency' => 'EUR',

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
];