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
 * @date 19/01/15 10:12
 */
namespace Modules\Goods\Controllers;

use Modules\Core\Controllers\CoreController;
use Modules\Goods\Models\Product;


class ProductController extends CoreController
{
    public function actionView($url)
    {
        $product = $this->getOr404(new Product(), [
            'url' => $url
        ]);
        $this->fetchBreadrumbs($product);
        echo $this->render('goods/product/view.html', [
            'model' => $product
        ]);
    }

    protected function fetchBreadrumbs(Product $product)
    {
        $category = $product->category;
        $categories = $category->tree()->ancestors()->order(['level'])->all();
        foreach ($categories as $item) {
            $this->addBreadcrumb($item->name, $item->getAbsoluteUrl());
        }
        $this->addBreadcrumb($category->name, $category->getAbsoluteUrl());

        $this->addTitle($product->name);
        $this->addBreadcrumb($product->name, $product->getAbsoluteUrl());
    }
} 