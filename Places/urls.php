<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 18:02
 */

return [
    '/' => [
        'name' => 'list',
        'callback' => '\Modules\Places\Controllers\PlaceController:list'
    ],
    '/{pk:i}' => [
        'name' => 'detail',
        'callback' => '\Modules\Places\Controllers\PlaceController:detail'
    ],
    '/map/{pk:i}' => [
        'name' => 'map',
        'callback' => '\Modules\Places\Controllers\PlaceController:map'
    ],
];