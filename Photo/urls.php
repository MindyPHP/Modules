<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Photo\Controllers\AlbumController:index'
    ],
    '/{pk:i}' => [
        'name' => 'view',
        'callback' => '\Modules\Photo\Controllers\AlbumController:view'
    ],
];