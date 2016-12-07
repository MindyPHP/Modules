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
 * @date 20/08/14.08.2014 18:07
 */

namespace Modules\Catalog\Sitemap;


use Modules\Catalog\Models\Product;
use Modules\Sitemap\Components\Sitemap;


class ProductSitemap extends Sitemap
{
    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Product::className();
    }

    public function getLoc($data)
    {
        return $this->reverse('catalog.product_detail', ['pk' => $data['id']]);
    }
}
