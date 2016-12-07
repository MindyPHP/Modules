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
 * @date 27/08/14.08.2014 14:50
 */

namespace Modules\Reviews\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\Reviews\ReviewsModule;

class ReviewController extends FrontendController
{
    public function actionIndex()
    {
        $module = Mindy::app()->getModule('Reviews');

        $formClass = $module->formClass;
        $form = new $formClass;
        $request = $this->getRequest();
        $this->addBreadcrumb(ReviewsModule::t('Reviews'));

        if ($request->getIsPost() && $form->populate($_POST)->isValid() && $form->save()) {
            if ($request->getIsAjax()) {
                echo $this->render('reviews/success.html');
                Mindy::app()->end();
            } else {
                $request->flash->success(ReviewsModule::t('Review successfully sent'));
                $request->refresh();
            }
        }

        $modelClass = $module->modelClass;
        $model = new $modelClass;
        $pager = new Pagination($model->objects()->published()->order(['-published_at']));
        echo $this->render('reviews/index.html', [
            'pager' => $pager,
            'reviews' => $pager->paginate(),
            'form' => $form,
            'enableForm' => $this->getModule()->enableForm
        ]);
    }

    public function actionView($pk)
    {
        $modelClass = $this->getModule()->modelClass;
        $model = $modelClass::objects()->filter(['pk' => $pk, 'is_published' => true])->get();
        if (!$model) {
            $this->error(404);
        }

        $this->addBreadcrumb(ReviewsModule::t('Reviews'), Mindy::app()->urlManager->reverse('reviews:index'));
        $this->addBreadcrumb($model->name);

        echo $this->render('reviews/view.html', [
            'model' => $model
        ]);
    }
}
