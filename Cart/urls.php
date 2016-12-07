<?php

return [
    '/' => [
        'name' => 'list',
        'callback' => '\Modules\Cart\Controllers\CartController:list',
    ],
    '/delete/{key}' => [
        'name' => 'delete',
        'callback' => '\Modules\Cart\Controllers\CartController:delete',
    ],
    '/quantity/{key}-{quantity:\d+}' => [
        'name' => 'quantity',
        'callback' => '\Modules\Cart\Controllers\CartController:quantity',
    ],
    '/quantity/{key}-inc' => [
        'name' => 'quantity_increase',
        'callback' => '\Modules\Cart\Controllers\CartController:increase',
    ],
    '/quantity/{key}-dec' => [
        'name' => 'quantity_decrease',
        'callback' => '\Modules\Cart\Controllers\CartController:decrease',
    ],
];
