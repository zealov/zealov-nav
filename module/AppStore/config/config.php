<?php
return [
    'admin' => [
        'prefix' => trim(env('ADMIN_PATH', 'admin'), '/'),
    ],
    'web' => [
        'prefix' => trim(env('APP_PATH', ''), '/'),
    ],
    'api' => [
        'prefix' => trim(env('API_PATH', 'api'), '/'),
    ],
    'middlewares'=>[
        'guest' => \Module\Blog\Middleware\RedirectIfAuthenticated::class,
    ],
];
