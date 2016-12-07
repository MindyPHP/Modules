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

namespace Modules\Services\Sitemap;

use Modules\Services\Models\Service;
use Modules\Services\ServicesModule;
use Modules\Sitemap\Components\Sitemap;

class ServicesSitemap extends Sitemap
{
    public function getModelClass()
    {
        return Service::className();
    }

    public function getQuerySet()
    {
        return $this->getModel()->objects()->currentSite();
    }

    public function getLoc($data)
    {
        if (isset($data['id'])) {
            $id = $data['id'];
            return $this->reverse('services.view', [$id]);
        } elseif (isset($data['reversed'])) {
            return $data['reversed'];
        }
        return '';
    }

    public function getLevel($data)
    {
        return isset($data['root']) ? 0 : 1;
    }

    public function getExtraItems()
    {
        return [
            [
                'root' => true,
                'name' => ServicesModule::t('Services'),
                'reversed' => $this->reverse('services:list')
            ]
        ];
    }
}
