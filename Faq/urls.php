<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Faq\Controllers\FaqController:index'
    ],
    '/question/{pk:i}' => [
        'name' => 'view',
        'callback' => '\Modules\Faq\Controllers\FaqController:view'
    ],
    '/question/create' => [
        'name' => 'question_create',
        'callback' => '\Modules\Faq\Controllers\QuestionController:create'
    ],
    '/{url:.*}' => [
        'name' => 'list',
        'callback' => '\Modules\Faq\Controllers\FaqController:list'
    ],
];
