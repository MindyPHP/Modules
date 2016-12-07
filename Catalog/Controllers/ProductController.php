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
 * @date 04/08/14.08.2014 13:33
 */

namespace Modules\Catalog\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Mindy\Table\Table;
use Modules\Catalog\CatalogModule;
use Modules\Catalog\Forms\OrderForm;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;
use Modules\Core\Controllers\FrontendController;
use Modules\Pages\Models\Page;

class ProductController extends FrontendController
{
    public function actionIndex()
    {
        $this->setBreadcrumbs([
            ['name' => CatalogModule::t('Shop'), 'url' => Mindy::app()->urlManager->reverse('catalog:index')],
        ]);

        $qs = Product::objects()->published();
        $pager = new Pagination($qs);
        echo $this->render('catalog/product/list.html', [
            'models' => $pager->paginate(),
            'pager' => $pager
        ]);
    }

    public function actionList($url)
    {
        $category = Category::objects()->filter(['url' => $url])->get();
        if ($category === null) {
            $this->error(404);
        }

        $parents = $category->objects()->ancestors()->order(['lft'])->all();
        $parents[] = $category;
        $breadcrumbs = [
            ['name' => CatalogModule::t('Shop'), 'url' => Mindy::app()->urlManager->reverse('catalog:index')]
        ];
        foreach ($parents as $parent) {
            $breadcrumbs[] = [
                'url' => $parent->getAbsoluteUrl(),
                'name' => (string)$parent,
            ];
        }
        $this->setBreadcrumbs($breadcrumbs);

        Mindy::app()->session->add('category', $category);

        $pager = new Pagination($category->production);
        echo $this->render('catalog/product/list.html', [
            'category' => $category,
            'models' => $pager->paginate(),
            'pager' => $pager
        ]);
    }

    public function actionView($id, $slug)
    {
        $this->addToLastView($id);

        $category = Mindy::app()->session->get('catalog_category');
        $model = Product::objects()->get(['id' => $id, 'slug' => $slug]);
        if ($model === null) {
            $this->error(404);
        }

        if (!$category) {
            $category = $model->category;
        }

        $parents = $category->objects()->ancestors()->order(['lft'])->all();
        $parents[] = $category;
        $breadcrumbs = [
            ['name' => CatalogModule::t('Shop'), 'url' => Mindy::app()->urlManager->reverse('catalog:index')]
        ];
        foreach ($parents as $parent) {
            $breadcrumbs[] = [
                'url' => $parent->getAbsoluteUrl(),
                'name' => (string)$parent,
            ];
        }
        $breadcrumbs[] = ['name' => (string)$model, 'url' => $model->getAbsoluteUrl()];
        $this->setBreadcrumbs($breadcrumbs);

        echo $this->render('catalog/product/detail.html', [
            'model' => $model,
            'images' => $model->images->all(),
            'similars' => $category->production->limit(5)->offset(0)->all(),
            'category' => $category,
            'categories' => $model->categories->exclude(['pk' => $category->pk])->all(),
            'last_view' => $this->getLastView($model->pk)
        ]);
    }

    protected function addToLastView($pk)
    {
        $session = Mindy::app()->session;
        $items = $session->get('catalog_last_view', []);
        $items[] = $pk;
        $items = array_unique($items);
        $session->add('catalog_last_view', array_slice($items, 0, 5));
    }

    protected function getLastView($pk)
    {
        $ids = $this->getRequest()->session->get('catalog_last_view', []);
        return Product::objects()->filter(['pk__in' => array_reverse($ids)])->exclude(['pk' => $pk])->all();
    }

    public function actionOrder($id)
    {
        $model = Product::objects()->get(['pk' => $id]);
        if ($model === null) {
            $this->error(404);
        }

        $this->setBreadcrumbs([
            ['name' => CatalogModule::t('Shop'), 'url' => Mindy::app()->urlManager->reverse('catalog:index')],
            ['name' => (string)$model->category, 'url' => $model->category->getAbsoluteUrl()],
            ['name' => (string)$model, 'url' => $model->getAbsoluteUrl()],
            ['name' => CatalogModule::t('Order')]
        ]);

        $form = new OrderForm();
        if ($this->getRequest()->isPost && $form->setAttributes($this->getRequest()->post) && $form->isValid()) {
            if ($model->order($form)) {
                $this->getRequest()->flash->success('Заказ успешно принят');
            }
            echo $this->render('catalog/success.html');
        } else {
            echo $this->render('catalog/order.html', [
                'model' => $model,
                'form' => $form,
            ]);
        }
    }
}
