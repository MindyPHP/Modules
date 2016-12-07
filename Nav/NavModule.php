<?php

namespace Modules\Nav;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class NavModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('get_nav', ['\Modules\Nav\Helpers\NavHelper', 'renderNav']);
        $tpl->addHelper('multispan', ['\Modules\Nav\Helpers\NavHelper', 'multispan']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'NavAdmin',
                ],
            ]
        ];
    }
}
