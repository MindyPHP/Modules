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
 * @date 28/08/14.08.2014 14:42
 */

namespace Modules\Offices\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\Feedback\Forms\FeedbackForm;
use Modules\Offices\Models\Category;
use Modules\Offices\Models\Office;
use Modules\Offices\OfficesModule;

class OfficeController extends FrontendController
{
    public function actionIndex()
    {
        $office = Office::objects()->get(['is_main' => true]);
        if ($office === null) {
            $this->error(404);
        }

        $this->forward(self::class, 'view', ['id' => $office->id], $this->getModule());
    }

    public function actionView($id)
    {
        $categories = Category::objects()->order(['position'])->all();
        $office = Office::objects()->get(['id' => $id]);
        if ($office === null) {
            $this->error(404);
        }

        echo $this->render('offices/view.html', [
            'categories' => $categories,
            'office' => $office
        ]);
    }

    public function actionPrint($id)
    {
        $office = Office::objects()->get(['id' => $id]);
        if ($office === null) {
            $this->error(404);
        }

        echo $this->render('offices/print.html', [
            'office' => $office
        ]);
    }
    
    public function actionList()
    {
        $form = $this->dispatchForm();
        $qs = Office::objects();
        $pager = new Pagination($qs);
        echo $this->render('offices/list.html', [
            'offices' => $pager->paginate(),
            'pager' => $pager,
            'form' => $form
        ]);
    }

    protected function dispatchForm()
    {
        $form = new FeedbackForm();
        $request = Mindy::app()->request;
        if ($request->getIsPost()) {
            if ($form->populate($request->post->all())->isValid() && $form->save()) {
                if ($request->isAjax) {
                    echo $this->render('feedback/success.html');
                    Mindy::app()->end();
                } else {
                    $request->flash->success("Ваше сообщение успешно отправлено");
                    if (isset($_GET['_next'])) {
                        $request->redirect($_GET['_next']);
                    } else {
                        $request->refresh();
                    }
                }
            } else {
                $request->flash->error('Пожалуйста исправьте ошибки');
            }
        }
        return $form;
    }
}
