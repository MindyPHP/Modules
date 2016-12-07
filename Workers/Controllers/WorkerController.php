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
 * @date 14/11/14 10:14
 */
namespace Modules\Workers\Controllers;

use Modules\Core\Controllers\CoreController;
use Modules\Workers\Models\Review;
use Modules\Workers\Models\Worker;

class WorkerController extends CoreController
{
    public function actionView($pk)
    {
        $worker = Worker::objects()->get(['pk' => $pk]);
        if (!$worker) {
            $this->error(404);
        }
        $reviews = Review::published()->filter(['worker' => $worker])->order(['-date'])->with(['worker'])->all();

        echo $this->render('workers/worker/view.html', [
            'worker' => $worker,
            'reviews' => $reviews
        ]);
    }
} 