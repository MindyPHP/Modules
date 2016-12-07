<?php

return [
    '/survey/' => [
        'name' => 'survey',
        'callback' => '\Modules\Antibank\Controllers\RequestController:survey',
    ],
    '/contact_us/' => [
        'name' => 'contact',
        'callback' => '\Modules\Antibank\Controllers\RequestController:contact',
    ],
    '/question/' => [
        'name' => 'question',
        'callback' => '\Modules\Antibank\Controllers\RequestController:question',
    ],
    '/question_alter/' => [
        'name' => 'question_alter',
        'callback' => '\Modules\Antibank\Controllers\RequestController:questionalter',
    ],
    '/offer/' => [
        'name' => 'offer',
        'callback' => '\Modules\Antibank\Controllers\RequestController:offer',
    ],
    '/consult/' => [
        'name' => 'consult',
        'callback' => '\Modules\Antibank\Controllers\RequestController:consult',
    ],
    '/consult_alt/' => [
        'name' => 'consult_alt',
        'callback' => '\Modules\Antibank\Controllers\RequestController:consultalt',
    ],
    '/more_partner/' => [
        'name' => 'partner',
        'callback' => '\Modules\Antibank\Controllers\RequestController:partner',
    ],
];
