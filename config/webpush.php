<?php

return [
    'vapid' => [
        'subject'     => env('WEBPUSH_SUBJECT', 'mailto:admin@centuriondiary.com'),
        'public_key'  => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
    ],
];
