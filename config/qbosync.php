<?php

return [
    'auth_mode' => 'oauth2',
    'client_id' => env('QBO_CLIENT_ID'),
    'client_secret' => env('QBO_CLIENT_SECRET'),
    'redirect_uri' => env('QBO_REDIRECT_URI'),
    'scope' => [
        'accounting' => 'com.intuit.quickbooks.accounting',
        'payment' => 'com.intuit.quickbooks.payment'
    ],
    'environment' => env('QBO_ENVIRONMENT'),
    'base_url' => [
        'development' => "Development",
        'production' => "Production"
    ]
];
