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
 * @date 19/01/15 08:03
 */
namespace Modules\Goods\Controllers;

use Mindy\Pagination\Pagination;
use Mindy\Query\Expression;
use Modules\Core\Controllers\CoreController;
use Modules\Goods\Models\Category;
use Modules\Goods\Models\Product;

class CategoryController extends CoreController
{
    public function actionIndex()
    {
        $category = Category::objects()->filter(['lft' => new Expression('rgt - 1')])->order(['root', 'lft'])->limit(1)->get();
        if (!$category) {
            $this->error(404);
        } else {
            $this->r->redirect($category);
        }
    }

    public function actionView($url)
    {
        $category = $this->getOr404(new Category(), ['url' => $url]);
        $productsQs = Product::objects()->filter(['category' => $category->id]);
        $pager = new Pagination($productsQs);

        $this->fetchBreadrumbs($category);

        echo $this->render('goods/category/view.html', [
            'model' => $category,
            'products' => $pager->paginate(),
            'pager' => $pager
        ]);
    }

    protected function fetchBreadrumbs(Category $category)
    {
        $categories = $category->tree()->ancestors()->order(['level'])->all();
        foreach ($categories as $item) {
            $this->addTitle($item->name);
            $this->addBreadcrumb($item->name, $item->getAbsoluteUrl());
        }
        $this->addTitle($category->name);
        $this->addBreadcrumb($category->name, $category->getAbsoluteUrl());
    }
} 