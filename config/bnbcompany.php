<?php

return [
    // Full company name
    'name' => env('BNB_COMPANY_NAME', 'BnB'),

    // Short form to use in compact places (e.g. logo acronym)
    'short' => env('BNB_COMPANY_SHORT', 'BnB'),

    // Tagline / motto for login and marketing
    'motto' => env('BNB_MOTTO', 'Professional hospitality platform'),

    // Welcome note for login promotional panel
    'welcome_note' => env('BNB_WELCOME_NOTE', 'Your comfort, our priority.'),

    // Links that may appear in footers or headers
    'links' => [
        'privacy' => env('BNB_PRIVACY_URL', '#'),
        'terms' => env('BNB_TERMS_URL', '#'),
    ],
];
