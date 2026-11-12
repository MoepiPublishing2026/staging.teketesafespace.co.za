<?php

return [
    'accounts' => [
        [
            'username' => 'admin',
            'name' => env('ADMIN_USER_NAME'),
            'email' => env('ADMIN_USER_EMAIL'),
            'password' => env('ADMIN_USER_PASSWORD'),
        ],
        [
            'username' => 'secondadmin',
            'name' => env('SECOND_ADMIN_USER_NAME'),
            'email' => env('SECOND_ADMIN_USER_EMAIL'),
            'password' => env('SECOND_ADMIN_USER_PASSWORD'),
        ],
        [
            'username' => 'safespace',
            'name' => env('SAFESPACE_ADMIN_USER_NAME'),
            'email' => env('SAFESPACE_ADMIN_USER_EMAIL'),
            'password' => env('SAFESPACE_ADMIN_USER_PASSWORD'),
        ],
    ],
];
