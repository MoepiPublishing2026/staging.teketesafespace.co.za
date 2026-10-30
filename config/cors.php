<?php

/*
|--------------------------------------------------------------------------
| Cross-Origin Resource Sharing ("Cross-Domain Misconfiguration")
|--------------------------------------------------------------------------
| The framework default is "allow every origin" for api/*, which let any website read
| /api/schools from a visitor's browser. The site's own pages call these endpoints
| same-origin, which needs no CORS at all, so by default NO other origin is allowed.
*/

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'OPTIONS'],

    'allowed_origins' => array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGINS', ''))))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'X-CSRF-TOKEN'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
