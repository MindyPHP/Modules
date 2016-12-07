<?php

return [
    '/{url:category\/[a-zA-Z0-9+_\-\.]+}?' => [
        'name' => 'list',
        'callback' => '\Modules\Portfolio\Controllers\PortfolioController:list',
    ],
    '/{pk}' => [
        'name' => 'view',
        'callback' => '\Modules\Portfolio\Controllers\PortfolioController:view',
    ],
];
