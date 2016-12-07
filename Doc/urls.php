<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Doc\Controllers\DocController:index'
    ],
    '/api/{file:.*}' => [
        'name' => 'api_view',
        'callback' => '\Modules\Doc\Controllers\ApiDocController:view',
    ],
    '/{url:.*}' => [
        'name' => 'view',
        'callback' => '\Modules\Doc\Controllers\DocController:view'
    ],
];
