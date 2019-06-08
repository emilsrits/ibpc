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
    ]
];