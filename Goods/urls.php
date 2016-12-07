<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Goods\Controllers\CategoryController:index'
    ],
    '/product/{url:.*}' => [
        'name' => 'product',
        'callback' => '\Modules\Goods\Controllers\ProductController:view'
    ],
    '/{url:.*}' => [
        'name' => 'category',
        'callback' => '\Modules\Goods\Controllers\CategoryController:view'
    ],
];
