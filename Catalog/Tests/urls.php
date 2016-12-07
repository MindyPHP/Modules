<?php

use Mindy\Router\Patterns;

return [
    '/core' => new Patterns('Modules.Admin.urls', 'admin'),
    '/c' => new Patterns('Modules.Catalog.urls', 'catalog'),
];
