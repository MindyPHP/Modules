<?php

return [
    '' => [
        'name' => 'list',
        'callback' => '\Modules\Video\Controllers\VideoController:index'
    ],
    '/{id:i}' => [
        'name' => 'view',
        'callback' => '\Modules\Video\Controllers\VideoController:view'
    ],
    '/category/{id:i}' => [
        'name' => 'category_view',
        'callback' => '\Modules\Video\Controllers\CategoryController:view'
    ]
];
