<?php

return [
    'site_key' => env('TURNSTILE_SITE_KEY'),
    'secret_key' => env('TURNSTILE_SECRET'),
    'hostnames' => array_values(array_filter(array_map('trim', explode(',', env('TURNSTILE_EXPECTED_HOSTNAMES', ''))))),
    'connect_timeout' => 3,
    'timeout' => 8,
];
