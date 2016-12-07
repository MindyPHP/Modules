<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Api\Controllers\ApiController:index'
    ],
    '/{name:[A-Za-z0-9-]+}' => [
        'name' => 'list',
        'callback' => '\Modules\Api\Controllers\ApiController:list'
    ],
    '/{name:[A-Za-z0-9-]+}/c-{action:\w+}' => [
        'name' => 'custom',
        'callback' => '\Modules\Api\Controllers\ApiController:custom'
    ],
    '/{name:[A-Za-z0-9-]+}/{pk:.*}' => [
        'name' => 'view',
        'callback' => '\Modules\Api\Controllers\ApiController:view'
    ],
];
