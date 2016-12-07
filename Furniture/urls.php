<?php

return [
    '/list' => [
        'name' => 'list',
        'callback' => '\Modules\Furniture\Controllers\FurnitureController:list',
    ],
    '/view/{slug:c}' => [
        'name' => 'view',
        'callback' => '\Modules\Furniture\Controllers\FurnitureController:view',
    ],
];
