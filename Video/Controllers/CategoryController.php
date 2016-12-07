<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 24/05/16 09:43
 */

namespace Modules\Video\Controllers;

use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\Video\Models\Category;
use Modules\Video\Models\Video;

class CategoryController extends FrontendController
{
    public function actionView($id)
    {
        $category = Category::objects()->get(['id' => $id]);
        if ($category === null) {
            $this->error(404);
        }

        $qs = Video::objects()->filter(['category' => $category]);
        $pager = new Pagination($qs, [
            'pageSize' => 9
        ]);

        echo $this->render('video/list.html', [
            'category' => $category,
            'categories' => Category::objects()->all(),
            'pager' => $pager,
            'models' => $pager->paginate()
        ]);
    }
}