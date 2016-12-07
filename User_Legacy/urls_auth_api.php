<?php

return [
    '/login' => [
        'callback' => '\Modules\User\Controllers\AuthApiController:login',
        'method' => 'post'
    ],
    '/logout' => [
        'callback' => '\Modules\User\Controllers\AuthApiController:logout',
    ],
    '/registration' => [
        'callback' => '\Modules\User\Controllers\AuthApiController:registration',
        'method' => 'post'
    ],
    '/registration/activate/{key}' => [
        'callback' => '\Modules\User\Controllers\AuthApiController:activate',
    ],
    '/recover/{key}?' => [
        'callback' => '\Modules\User\Controllers\RecoverApiController:recover'
    ],
];