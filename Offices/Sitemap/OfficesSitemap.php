<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 03/07/14.07.2014 16:41
 */

namespace Modules\Offices\Sitemap;

use Modules\Offices\OfficesModule;
use Modules\Sitemap\Components\Sitemap;

class OfficesSitemap extends Sitemap
{
    public function getModelClass()
    {
        return null;
    }

    public function getQuerySet()
    {
        return null;
    }

    public function getLoc($data)
    {
        return $data['reversed'];
    }


    public function getExtraItems()
    {
        return [
            [
                'reversed' => $this->reverse('offices.offices'),
                'name' => OfficesModule::t('Contacts')
            ]
        ];
    }
}
