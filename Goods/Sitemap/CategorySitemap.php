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
 * @date 22/01/15 11:54
 */
namespace Modules\Goods\Sitemap;

use Mindy\Base\Mindy;
use Modules\Goods\GoodsModule;
use Modules\Sitemap\Components\Sitemap;

class CategorySitemap extends Sitemap
{
    public function getModelClass()
    {
        return Mindy::app()->getModule('Goods')->categoryModel;
    }

    public function getLoc($data)
    {
        return isset($data['reversed']) ? $data['reversed'] : $this->reverse('goods:category', [$data['url']]);
    }

    public function getQuerySet()
    {
        $qs = parent::getQuerySet();
        return $qs->order(['root', 'lft']);
    }

    public function getExtraItems()
    {
        return [
            [
                'name' => GoodsModule::t('Catalog'),
                'reversed' => $this->reverse('goods:index')
            ],
        ];
    }
}
