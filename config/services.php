<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),

    ],


    'google' => [

        'client_id' => env('GOOGLE_CLIENT_ID'),


        'client_secret' => env('GOOGLE_CLIENT_SECRET'),

        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
];
