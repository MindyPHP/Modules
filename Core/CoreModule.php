<?php

namespace Modules\Core;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Core\Library\CoreLibrary;

class CoreModule extends Module
{
    public static function preConfigure()
    {
        Mindy::app()->template->addLibrary(new CoreLibrary());
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                ['name' => self::t('Modules'), 'url' => 'core:module_list'],
                ['name' => self::t('Routes'), 'url' => 'core:route_list']
            ]
        ];
    }

    public function getVersion()
    {
        return 2.0;
    }
}
