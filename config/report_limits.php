<?php

return [
    // Provisional policy; review against observed legitimate shared-IP usage.
    'session_attempts' => (int) env('REPORT_LIMIT_SESSION_ATTEMPTS', 3),
    'ip_attempts' => (int) env('REPORT_LIMIT_IP_ATTEMPTS', 300),
    'window_seconds' => (int) env('REPORT_LIMIT_WINDOW_SECONDS', 600),
];
