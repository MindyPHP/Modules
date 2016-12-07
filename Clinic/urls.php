<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 15:07
 */

return [
    '/' => [
        'name' => 'list',
        'callback' => '\Modules\Clinic\Controllers\ClinicController:index'
    ],
    '/dep/{pk:i}' => [
        'name' => 'detail',
        'callback' => '\Modules\Clinic\Controllers\ClinicController:detail'
    ],
    '/dep/page/{pk:i}' => [
        'name' => 'page_detail',
        'callback' => '\Modules\Clinic\Controllers\PageController:detail'
    ]
];