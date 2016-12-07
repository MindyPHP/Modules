<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 03/10/14 09:49
 */

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Crm\Controllers\CrmController:index',
    ],
    '/pay/' => [
        'name' => 'pay',
        'callback' => '\Modules\Crm\Controllers\CrmController:pay',
    ],
    '/request/' => [
        'name' => 'request',
        'callback' => '\Modules\Crm\Controllers\CrmController:request',
    ],
    '/account/' => [
        'name' => 'account_wo_date',
        'callback' => '\Modules\Crm\Controllers\CrmController:account',
    ],
    '/act/' => [
        'name' => 'act_wo_date',
        'callback' => '\Modules\Crm\Controllers\CrmController:act',
    ],
    '/account/{date:[\w\-]+}' => [
        'name' => 'account',
        'callback' => '\Modules\Crm\Controllers\CrmController:account',
    ],
    '/act/{date:[\w\-]+}' => [
        'name' => 'act',
        'callback' => '\Modules\Crm\Controllers\CrmController:act',
    ],
    '/project/{pk:\w+}' => [
        'name' => 'project',
        'callback' => '\Modules\Crm\Controllers\CrmController:project',
    ]
];