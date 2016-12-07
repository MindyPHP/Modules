<?php

namespace Modules\Meta;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class MetaModule extends Module
{
    public $onSite = false;

    public function init()
    {
        if (is_null($this->onSite)) {
            $this->onSite = Mindy::app()->hasModule('Sites');
        }
    }

    public function getVersion()
    {
        return 1.0;
    }

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('meta', ['\Modules\Meta\Helpers\MetaHelper', 'getMeta']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'MetaAdmin',
                ]
            ]
        ];
    }
}
