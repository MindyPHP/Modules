<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Admin\Controllers\AdminDispatchController:dispatchIndex'
    ],
    '/dashboard' => [
        'name' => 'dashboard',
        'callback' => '\Modules\Admin\Controllers\DashboardController:index'
    ],
    '/settings' => [
        'name' => 'settings',
        'callback' => '\Modules\Admin\Controllers\SettingsController:index'
    ],

    '/auth/login' => [
        'name' => 'login',
        'callback' => '\Modules\Admin\Controllers\AuthController:login'
    ],
    '/auth/logout' => [
        'name' => 'logout',
        'callback' => '\Modules\Admin\Controllers\AuthController:logout'
    ],
    '/auth/recover' => [
        'name' => 'recover',
        'callback' => '\Modules\Admin\Controllers\AuthController:recover'
    ],

    '/manage/{module:a}/{admin:a}/{action:a}' => [
        'name' => 'action',
        'callback' => '\Modules\Admin\Controllers\AdminDispatchController:dispatch'
    ],
];
