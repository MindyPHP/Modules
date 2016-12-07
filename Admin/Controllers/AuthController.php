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
 * @date 03/07/14.07.2014 18:50
 */

namespace Modules\Admin\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;
use Modules\Auth\Forms\LoginForm;

class AuthController extends FrontendController
{
    public function allowedActions()
    {
        return ['login', 'logout'];
    }

    public function actionLogin()
    {
        $request = $this->getRequest();
        $form = new LoginForm();
        if ($request->getIsPost() && $form->populate($_POST)->isValid() && $form->login()) {
            $user = Mindy::app()->getUser();
            if (isset($_GET['_next'])) {
                $request->redirect($_GET['_next']);
            } else if ($user->is_staff || $user->is_superuser) {
                $request->redirect('admin:index');
            } else {
                $request->redirect(Mindy::app()->getModule('User')->userRoute);
            }
        }

        echo $this->render('admin/login.html', [
            'form' => $form
        ]);
    }

    /**
     * Logout the current user and redirect to returnLogoutUrl.
     */
    public function actionLogout()
    {
        $auth = Mindy::app()->auth;
        if ($auth->isGuest) {
            $this->getRequest()->redirect(Mindy::app()->homeUrl);
        }

        $auth->logout();
        $this->getRequest()->redirect('admin:login');
    }
}
