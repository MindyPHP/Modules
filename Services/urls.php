<?php

use Modules\Services\Controllers\ServiceController;

return [
    '/' => [
        'name' => 'list',
        'callback' => [ServiceController::class, 'list']
    ],
    '/view/{id:i}' => [
        'name' => 'view',
        'callback' => [ServiceController::class, 'view']
    ]
];
