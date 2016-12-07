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
 * @date 11/09/14.09.2014 14:25
 */

namespace Modules\Crm;

use Mindy\Base\Module;

class CrmModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => self::t('Clients'),
                    'adminClass' => 'ClientAdmin',
                ],
                [
                    'name' => self::t('Projects'),
                    'adminClass' => 'ProjectAdmin',
                ],
                [
                    'name' => self::t('Subscribes'),
                    'adminClass' => 'SubscribeAdmin',
                ],
            ]
        ];
    }
}