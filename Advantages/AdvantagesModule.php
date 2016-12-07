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
 * @date 07/11/14 15:25
 */
namespace Modules\Advantages;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class AdvantagesModule extends Module
{
    public static function preConfigure()
    {
        Mindy::app()->template->addHelper('advantages', ['\Modules\Advantages\Helpers\AdvantageHelper', 'renderAdvantages']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => $this->getName(),
                    'adminClass' => 'AdvantageAdmin',
                ]
            ]
        ];
    }
}
