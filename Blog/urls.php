<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Blog\Controllers\PostController:index',
    ],
    '/{pk:i}-{slug:c}/c/send' => [
        'name' => 'comment_send',
        'callback' => '\Modules\Blog\Controllers\CommentController:save',
    ],
    '/{pk:i}-{slug:c}/c/' => [
        'name' => 'comment_list',
        'callback' => '\Modules\Blog\Controllers\CommentController:view',
    ],
    '/{pk:i}-{slug:c}' => [
        'name' => 'view',
        'callback' => '\Modules\Blog\Controllers\PostController:view',
    ],
    '/c/{slug:c}' => [
        'name' => 'list',
        'callback' => '\Modules\Blog\Controllers\CategoryController:list',
    ],
];
