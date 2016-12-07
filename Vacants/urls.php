<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Vacants\Controllers\VacanciesController:index'
    ],
    '/response' => [
        'name' => 'response',
        'callback' => '\Modules\Vacants\Controllers\VacanciesController:response'
    ],
];
