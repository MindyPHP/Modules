<?php

return [
    '' => [
        'name' => 'index',
        'callback' => '\Modules\Reviews\Controllers\ReviewController:index'
    ],
    '/{pk:i}' => [
        'name' => 'view',
        'callback' => '\Modules\Reviews\Controllers\ReviewController:view'
    ]
];