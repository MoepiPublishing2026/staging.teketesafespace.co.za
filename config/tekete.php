<?php

return [
    'workshop_booking_url' => env('WORKSHOP_BOOKING_URL', 'https://bookings.teketesafespace.co.za'),

    // Content-Security-Policy rollout: report-only | enforce | off.
    'csp_mode'       => env('CSP_MODE', 'report-only'),
    'csp_report_uri' => env('CSP_REPORT_URI', '/csp-report'),

    // Strict-Transport-Security max-age in seconds (sent over HTTPS only). Default 180 days.
    'hsts_max_age'   => (int) env('HSTS_MAX_AGE', 15552000),
];
