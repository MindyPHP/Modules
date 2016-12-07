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

namespace Modules\Photo;

use Mindy\Base\Module;

class PhotoModule extends Module
{
    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => PhotoModule::t('Photo albums'),
                    'adminClass' => 'AlbumAdmin',
                ],
            ]
        ];
    }
}