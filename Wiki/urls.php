<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Wiki\Controllers\WikiController:index',
    ],
    '{url:.*}:update' => [
        'name' => 'update',
        'callback' => '\Modules\Wiki\Controllers\WikiController:update',
    ],
    '{url:.*}' => [
        'name' => 'view',
        'callback' => '\Modules\Wiki\Controllers\WikiController:view',
    ],
];
