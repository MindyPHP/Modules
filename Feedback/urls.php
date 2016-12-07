<?php

return [
    '/' => [
        'name' => 'feedback',
        'callback' => '\Modules\Feedback\Controllers\FeedbackController:index'
    ],
    '/backcall' => [
        'name' => 'backcall',
        'callback' => '\Modules\Feedback\Controllers\BackCallController:index'
    ]
];
