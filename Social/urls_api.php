<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Social\Controllers\SocialApiController:index'
    ],
    '/delete' => [
        'name' => 'delete',
        'callback' => '\Modules\Social\Controllers\SocialApiController:delete'
    ],
];