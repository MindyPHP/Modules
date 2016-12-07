<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Controllers;

use Mindy\Base\Mindy;
use Modules\Auth\Forms\ChangePasswordForm;
use Modules\Core\Controllers\FrontendController;

class ChangePasswordController extends FrontendController
{
    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'users' => ['@']
            ],
        ];
    }

    public function actionIndex()
    {
        $request = $this->getRequest();
        $form = new ChangePasswordForm([
            'instance' => Mindy::app()->getUser()
        ]);
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid() && $form->save()) {
            $request->redirect('auth:change_password_succes');
            Mindy::app()->end();
        }

        echo $this->render('auth/password/form.html', [
            'form' => $form
        ]);
    }

    public function actionSuccess()
    {
        echo $this->render('auth/password/success.html');
    }
}