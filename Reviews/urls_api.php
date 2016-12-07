<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Reviews\Controllers\ReviewApiController:index'
    ],
    '/{pk:i}' => [
        'name' => 'view',
        'callback' => '\Modules\Reviews\Controllers\ReviewApiController:view'
    ],
    '/create' => [
        'name' => 'create',
        'callback' => '\Modules\Reviews\Controllers\ReviewApiController:create'
    ]
];