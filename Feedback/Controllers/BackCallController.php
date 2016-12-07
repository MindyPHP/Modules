<?php
/**
 * Created by IntelliJ IDEA.
 * User: max
 * Date: 19/04/16
 * Time: 17:39
 */

namespace Modules\Feedback\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;
use Modules\Feedback\Forms\BackCallForm;

class BackCallController extends FrontendController
{
    public function actionIndex()
    {
        $form = new BackCallForm();
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid() && $form->save()) {
            echo $this->render('feedback/back_call/success.html');
            Mindy::app()->end();
        }

        echo $this->render('feedback/back_call/form.html', [
            'form' => $form
        ]);
    }
}