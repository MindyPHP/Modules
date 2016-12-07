<?php

return [
    '/{pk}/c/send' => [
        'name' => 'comment_send',
        'callback' => '\Modules\Solutions\Controllers\CommentController:save',
    ],
    '/{pk}/c' => [
        'name' => 'comment_list',
        'callback' => '\Modules\Solutions\Controllers\CommentController:view',
    ],
    '/{pk}' => [
        'name' => 'view',
        'callback' => '\Modules\Solutions\Controllers\SolutionController:view'
    ],
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Solutions\Controllers\SolutionController:index'
    ]
];
