<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 03/07/14.07.2014 16:26
 */

namespace Modules\Slider;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class SliderModule extends Module
{
    /**
     * @var array
     */
    public $imageSizes = [
        'thumb' => [978, 260],
    ];

    public function getVersion()
    {
        return '1.0';
    }

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('slider', ['\Modules\Slider\Helper\SliderHelper', 'render']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Slides'),
                    'adminClass' => 'SlideAdmin'
                ]
            ]
        ];
    }
}
