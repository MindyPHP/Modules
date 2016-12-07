<?php

namespace Modules\Catalog;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class CatalogModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('catalog_navigation', ['Modules\Catalog\Helpers\NavigationHelper', 'render']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Categories'),
                    'adminClass' => 'CategoryAdmin',
                ],
                [
                    'name' => self::t('Productions'),
                    'adminClass' => 'ProductAdmin',
                ]
            ]
        ];
    }
}
