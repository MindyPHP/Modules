<?php

error_reporting(-1);
ini_set('error_reporting', -1);

define('YII_TEST', true);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
define('YII_ENABLE_EXCEPTION_HANDLER', false);
define('YII_ENABLE_ERROR_HANDLER', false);

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../../vendor/aura/autoload/src.php');

$loader = new \Aura\Autoload\Loader;
$loader->add('Modules\\', __DIR__ . '/../../../');
$loader->register();

$config = [
    'basePath' => '../../../',
    'managers' => [
        'admin@admin.com' => 'sender'
    ],
    'components' => [
        'urlManager' => [
            'class' => '\Mindy\Base\UrlManager',
            'urlsAlias' => 'Modules.Catalog.Tests.urls'
        ],
        'mail' => [
            'class' => '\Modules\Mail\Components\DbMailer',
            'checker' => false,
            'transport' => [
                'class' => 'Swift_NullTransport',
            ],
        ],
        'signal' => [
            'class' => '\Mindy\Base\EventManager',
            'events' => __DIR__ . '/../events.php',
        ],
        'template' => [
            'class' => '\Mindy\Template\Renderer',
            'mode' => \Mindy\Template\Renderer::RECOMPILE_ALWAYS,
        ],
        'finder' => [
            'class' => '\Mindy\Finder\FinderFactory',
        ],
        'auth' => [
            'class' => '\Modules\User\Components\Auth',
            'allowAutoLogin' => true,
            'autoRenewCookie' => true,
        ],
    ],
    'modules' => [
        'Catalog',
    ],
];

\Mindy\Base\Mindy::getInstance($config);