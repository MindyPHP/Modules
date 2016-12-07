<?php

return [
    '/{type:c}?' => [
        'name' => 'search',
        'callback' => '\Modules\Search\Controllers\SearchController:search'
    ],
];
