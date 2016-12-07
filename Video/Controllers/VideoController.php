<?php

/**
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 09/09/14.09.2014 10:39
 */

namespace Modules\Video\Controllers;

use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\Video\Models\Category;
use Modules\Video\Models\Video;

class VideoController extends FrontendController
{
    public function actionView($id)
    {
        $model = Video::objects()->get(['id' => $id]);
        if($model === null) {
            $this->error(404);
        }
        echo $this->render('video/detail.html', ['model' => $model]);
    }

    public function actionIndex()
    {
        $qs = Video::objects()->all();
        $pager = new Pagination($qs, [
            'pageSize' => 9
        ]);
        echo $this->render('video/list.html', [
            'categories' => Category::objects()->all(),
            'models' => $pager->paginate(),
            'pager' => $pager
        ]);
    }
}
