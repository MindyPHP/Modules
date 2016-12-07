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

namespace Modules\Pages\Sitemap;

use Exception;
use Modules\Sitemap\Components\Sitemap;

/**
 * Class PageSitemap
 * @package Modules\Pages
 */
abstract class FlatPageSitemap extends Sitemap
{
    public function getPriority($data)
    {
        return '0.4';
    }

    public function getModelClass()
    {
        throw new Exception('Override method');
    }

    public function getLastMod($data)
    {
        $date = isset($data['updated_at']) ? $data['updated_at'] : $data['created_at'];
        return $this->formatLastMod($date);
    }

    public function getQuerySet()
    {
        return parent::getQuerySet();
    }

    public function getLoc($data)
    {
        throw new Exception('Override method');
    }
}
