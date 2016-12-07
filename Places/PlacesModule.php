<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 17:35
 */

namespace Modules\Places;

use Mindy\Base\Module;

class PlacesModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Places'),
                    'adminClass' => 'PlaceAdmin',
                ],
            ]
        ];
    }
}
