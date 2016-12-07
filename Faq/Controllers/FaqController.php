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
 * @date 14/09/14.09.2014 13:05
 */

namespace Modules\Faq\Controllers;

use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Faq\Models\Category;
use Modules\Faq\Models\Question;

class FaqController extends CoreController
{
    public function actionIndex()
    {
        $pager = new Pagination(Question::objects()->filter(['is_active' => true])->all());
        echo $this->render('faq/index.html', [
            'categories' => Category::objects()->all(),
            'pager' => $pager,
            'questions' => $pager->paginate()
        ]);
    }

    public function actionList($url)
    {
        $category = Category::objects()->filter(['url' => $url])->get();
        if ($category === null) {
            $this->error(404);
        }

        $pager = new Pagination($category->questions, [
            'pageSize' => 50
        ]);

        echo $this->render('faq/list.html', [
            'categories' => Category::objects()->all(),
            'category' => $category,
            'pager' => $pager,
            'questions' => $pager->paginate()
        ]);
    }

    public function actionView($pk)
    {
        $question = Question::objects()->filter(['is_active' => true, 'pk' => $pk])->get();
        if ($question === null) {
            $this->error(404);
        }

        $pager = new Pagination($question->answers);
        echo $this->render('faq/view.html', [
            'question' => $question,
            'pager' => $pager,
            'answers' => $pager->paginate()
        ]);
    }
}
