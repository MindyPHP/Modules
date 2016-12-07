<?php

namespace Modules\Feedback\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;
use Modules\Feedback\Forms\FeedbackForm;

class FeedbackController extends FrontendController
{
    public function actionIndex()
    {
        $this->addBreadcrumb('Получить консультацию');

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

        echo $this->render('feedback/form.html', [
            'form' => $form
        ]);
    }
}
