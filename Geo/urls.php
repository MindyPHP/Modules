<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 07/06/16 13:09
 */

return [
    '/country/autocomplete' => [
        'method' => 'get',
        'callback' => '\Modules\Geo\Controllers\Api\CountryApiController:autocomplete'
    ],
    '/region/autocomplete' => [
        'method' => 'get',
        'callback' => '\Modules\Geo\Controllers\Api\RegionApiController:autocomplete'
    ],
    '/city/autocomplete' => [
        'method' => 'get',
        'callback' => '\Modules\Geo\Controllers\Api\CityApiController:autocomplete'
    ]
];