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
 * @date 19/11/14 10:15
 */
namespace Modules\Workers\Controllers;

use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Workers\Forms\ReviewForm;
use Modules\Workers\Models\Review;

class ReviewController extends CoreController
{
    public function actionSend($pk = null)
    {
        $form = new ReviewForm();
        if ($pk) {
            $form->worker = $pk;
        }

        if($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->redirect('workers.review_success');
        }

        echo $this->render('workers/reviews/send.html', [
            'form' => $form,
            'pk' => $pk
        ]);
    }

    public function actionSuccess()
    {
        echo $this->render('workers/reviews/success.html');
    }

    public function actionList()
    {
        $all = Review::published()->with(['worker'])->getQuerySet();
        $text = Review::published()->with(['worker'])->filter(['video__isnull' => true]);
        $video = Review::published()->with(['worker'])->filter(['video__isnull' => false]);

        $config = ['pageSize' => 9];
        $pager_all = new Pagination($all, $config);
        $pager_text = new Pagination($text, $config);
        $pager_video = new Pagination($video, $config);

        $reviews_all = $pager_all->paginate();
        $reviews_text = $pager_text->paginate();
        $reviews_video = $pager_video->paginate();

        echo $this->render('workers/reviews/list.html', [
            'pager_all' => $pager_all,
            'pager_text' => $pager_text,
            'pager_video' => $pager_video,

            'reviews_all' => $reviews_all,
            'reviews_text' => $reviews_text,
            'reviews_video' => $reviews_video
        ]);
    }
}