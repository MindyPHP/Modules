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
 * @date 23/10/14 11:43
 */
namespace Modules\Furniture;

use Mindy\Base\Module;

class FurnitureModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Furniture'),
                    'adminClass' => 'FurnitureAdmin',
                ],
                [
                    'name' => self::t('Requests'),
                    'adminClass' => 'RequestAdmin',
                ],
            ]
        ];
    }
}
