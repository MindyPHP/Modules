<?php

return [
    '/{place:\d+}/{month:\d+}/{year:\d+}' => [
        'name' => 'month',
        'callback' => '\Modules\Tour\Controllers\TourController:index'
    ],
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Tour\Controllers\TourController:index'
    ],
    '/time/{place:\d+}/{month:\d+}/{year:\d+}/{day:\d+}' => [
        'name' => 'time',
        'callback' => '\Modules\Tour\Controllers\TourController:append'
    ],
    '/delete' => [
        'name' => 'delete',
        'callback' => '\Modules\Tour\Controllers\TourController:delete'
    ],
    '/order/{id:\d+}' => [
        'name' => 'order',
        'callback' => '\Modules\Tour\Controllers\TourController:order'
    ]
];
