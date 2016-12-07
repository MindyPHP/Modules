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
 * @date 29/09/14.09.2014 19:10
 */

namespace Modules\Blog\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Blog\BlogModule;
use Modules\Blog\Models\Category;
use Modules\Core\Controllers\FrontendController;

class CategoryController extends FrontendController
{
    public function actionList($slug)
    {
        $breadcrumbs = [
            ['name' => BlogModule::t('Blog'), 'url' => Mindy::app()->urlManager->reverse('blog:index')]
        ];
        $model = Category::objects()->filter(['slug' => $slug])->get();
        if ($model === null) {
            $this->error(404);
        }

        $pager = new Pagination($model->posts);
        echo $this->render('blog/list.html', [
            'category' => $model,
            'breadcrumbs' => $breadcrumbs,
            'models' => $pager->paginate(),
            'pager' => $pager
        ]);
    }
}
