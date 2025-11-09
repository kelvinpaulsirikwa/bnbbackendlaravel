<?php

return [
    // Full company name
    'name' => env('BNB_COMPANY_NAME', 'BnB'),

    // Short form to use in compact places
    'short' => env('BNB_COMPANY_SHORT', 'BnB'),

    // Links that may appear in footers or headers
    'links' => [
        'privacy' => env('BNB_PRIVACY_URL', '#'),
        'terms' => env('BNB_TERMS_URL', '#'),
    ],
];
