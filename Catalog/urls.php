<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Catalog\Controllers\ProductController:index'
    ],
    '/{id:i}-{slug:c}' => [
        'name' => 'product_detail',
        'callback' => '\Modules\Catalog\Controllers\ProductController:view'
    ],
    '/{id:i}/order' => [
        'name' => 'product_order',
        'callback' => '\Modules\Catalog\Controllers\ProductController:order'
    ],
    '/{url:w}' => [
        'name' => 'list',
        'callback' => '\Modules\Catalog\Controllers\ProductController:list'
    ],
];
