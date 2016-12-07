<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 30/11/14 17:59
 */

namespace Modules\Faq\Controllers;

use Modules\Core\Controllers\CoreController;
use Modules\Faq\Forms\QuestionForm;

class QuestionController extends CoreController
{
    public function actionCreate()
    {
        $form = new QuestionForm();
        if ($this->getRequest()->getIsPost() && $form->populate($_POST)->isValid() && $form->save()) {
            $this->getRequest()->redirect($form->getInstance());
        }

        echo $this->render('faq/question_create.html', [
            'form' => $form
        ]);
    }
}
