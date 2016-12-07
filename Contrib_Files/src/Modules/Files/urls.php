<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Files\Controllers\FilesController:index'
    ],
    '/api/' => [
        'name' => 'api',
        'callback' => '\Modules\Files\Controllers\FilesController:api'
    ],
    '/upload/' => [
        'name' => 'upload',
        'callback' => '\Modules\Files\Controllers\FilesController:upload'
    ],
    '/files_upload/' => [
        'name' => 'files_upload',
        'callback' => '\Modules\Files\Controllers\UploadController:upload'
    ],
];
