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
 * @date 22/01/15 12:04
 */
namespace Modules\Goods\Sitemap;

use Mindy\Base\Mindy;
use Modules\Goods\GoodsModule;
use Modules\Goods\Models\Product;
use Modules\Sitemap\Components\Sitemap;

class ProductSitemap extends Sitemap
{
    public function getModelClass()
    {
        return Mindy::app()->getModule('Goods')->productModel;
    }

    public function getLoc($data)
    {
        return isset($data['reversed']) ? $data['reversed'] : $this->reverse('goods:product', [$data['url']]);
    }
}