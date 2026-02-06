<?php

/**
 * Customizations for l5-swagger. Merged with vendor config.
 * Swagger UI is disabled in production (404) via middleware.
 */
return [
    'defaults' => [
        'routes' => [
            'group_options' => [
                'middleware' => ['prevent_swagger_in_production'],
            ],
        ],
    ],
];
