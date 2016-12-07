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
 * @date 10/09/14.09.2014 12:45
 */

namespace Modules\Portfolio\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\Portfolio\Models\Category;
use Modules\Portfolio\Models\Portfolio;

class PortfolioController extends FrontendController
{
    public $pageSize = 2;

    public function actionList($url = null)
    {
        $extra = [];
        $qs = Portfolio::objects();

        if (!empty($url)) {
            $category = Category::objects()->get(['url' => $url]);
            if ($category === null) {
                $this->error(404);
            }

            $qs->filter(['category' => $category]);
            $extra = ['category' => $category];
        }

        $pager = new Pagination($qs, [
            'pageSize' => $this->pageSize
        ]);
        echo $this->render('portfolio/list.html', array_merge([
            'models' => $pager->paginate(),
            'pager' => $pager,
        ], $extra));
    }

    public function actionView($pk)
    {
        $model = Portfolio::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }

        $images = $model->images->all();
        echo $this->render('portfolio/detail.html', [
            'model' => $model,
            'images' => $images
        ]);
    }
}
