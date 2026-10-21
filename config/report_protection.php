<?php

return [
    'site_key' => env('TURNSTILE_SITE_KEY'),
    'secret_key' => env('TURNSTILE_SECRET_KEY'),
    'hostnames' => array_filter(array_map('trim', explode(',', env('TURNSTILE_EXPECTED_HOSTNAMES', '')))),
    'action' => 'report_submit',
    'connect_timeout' => (int) env('TURNSTILE_CONNECT_TIMEOUT_SECONDS', 3),
    'timeout' => (int) env('TURNSTILE_TIMEOUT_SECONDS', 8),
    // Provisional starting values, requiring approval before production rollout.
    // IP ceilings are deliberately higher for schools and mobile carrier NAT.
    'session_burst' => (int) env('REPORT_LIMIT_SESSION_BURST', 10),
    'ip_burst' => (int) env('REPORT_LIMIT_IP_BURST', 300),
    'burst_seconds' => (int) env('REPORT_LIMIT_BURST_SECONDS', 600),
    'session_sustained' => (int) env('REPORT_LIMIT_SESSION_SUSTAINED', 30),
    'ip_sustained' => (int) env('REPORT_LIMIT_IP_SUSTAINED', 1000),
    'sustained_seconds' => (int) env('REPORT_LIMIT_SUSTAINED_SECONDS', 3600),
];
