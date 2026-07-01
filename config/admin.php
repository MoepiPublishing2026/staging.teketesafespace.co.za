<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin inactivity timeout (minutes)
    |--------------------------------------------------------------------------
    |
    | After this many minutes without user activity, admin sessions are
    | logged out client-side and the user is sent to the admin login page.
    |
    */

    'inactivity_timeout_minutes' => (int) env('ADMIN_INACTIVITY_TIMEOUT_MINUTES', 30),

];
