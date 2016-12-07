<?php

return [
    '/{name:c}' => [
        'name' => 'auth',
        'callback' => '\Modules\Social\Controllers\SocialController:auth'
    ],
];