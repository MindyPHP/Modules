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
 * @date 17/02/15 15:01
 */
namespace Modules\Tour;

use Mindy\Base\Module;

class TourModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => TourModule::t('Places'),
                    'adminClass' => 'PlaceAdmin'
                ],
                [
                    'name' => TourModule::t('Events'),
                    'adminClass' => 'EventAdmin'
                ],
                [
                    'name' => TourModule::t('Orders'),
                    'adminClass' => 'OrderAdmin'
                ]
            ]
        ];
    }
}
