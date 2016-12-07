<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Blog\Controllers\PostApiController:index',
    ],
    '/view' => [
        'name' => 'view',
        'callback' => '\Modules\Blog\Controllers\PostApiController:view',
    ],
    '/category' => [
        'name' => 'list',
        'callback' => '\Modules\Blog\Controllers\CategoryApiController:list',
    ],
];
