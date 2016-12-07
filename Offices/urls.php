<?php

return [
    '' => [
        'name' => 'offices',
        'callback' => '\Modules\Offices\Controllers\OfficeController:index'
    ],
    '/{id:i}' => [
        'name' => 'view',
        'callback' => '\Modules\Offices\Controllers\OfficeController:view'
    ],
    '/{id:i}/print' => [
        'name' => 'print',
        'callback' => '\Modules\Offices\Controllers\OfficeController:print'
    ]
];
