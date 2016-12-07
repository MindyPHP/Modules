<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/11/14 16:47
 */
namespace Modules\Rotator;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class RotatorModule extends Module
{
    public static function preConfigure()
    {
        Mindy::app()->template->addHelper('rotator', ['\Modules\Rotator\Helpers\RotatorHelper', 'renderRotator']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'RotatorAdmin',
                ]
            ]
        ];
    }
}
