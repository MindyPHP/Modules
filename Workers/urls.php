<?php

return [
    '/' => [
        'name' => 'list',
        'callback' => '\Modules\Workers\Controllers\DepartmentController:list'
    ],
    '/{pk:\d+}' => [
        'name' => 'view',
        'callback' => '\Modules\Workers\Controllers\WorkerController:view'
    ],
    '/reviews/' => [
        'name' => 'reviews',
        'callback' => '\Modules\Workers\Controllers\ReviewController:list'
    ],
    '/review/' => [
        'name' => 'review_send',
        'callback' => '\Modules\Workers\Controllers\ReviewController:send'
    ],
    '/review/{pk:\d+}' => [
        'name' => 'review_worker',
        'callback' => '\Modules\Workers\Controllers\ReviewController:send'
    ],
    '/review/success' => [
        'name' => 'review_success',
        'callback' => '\Modules\Workers\Controllers\ReviewController:success'
    ],
];