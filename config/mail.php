<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.mail.ru'),
    'port' => env('MAIL_PORT', 587),
    'from' => [
        'address' => 'pt.82@mail.ru',
        'name' => 'InternetShop',
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME', 'pt.82@mail.ru'),
    'password' => env('MAIL_PASSWORD', 'my_pass'),

    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false
];

