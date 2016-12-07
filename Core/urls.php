<?php

return [
    '/modules/' => [
        'name' => 'module_list',
        'callback' => '\Modules\Core\Controllers\Admin\ModulesController:list'
    ],
    '/routes/' => [
        'name' => 'route_list',
        'callback' => '\Modules\Core\Controllers\Admin\RouteController:list'
    ],
];
