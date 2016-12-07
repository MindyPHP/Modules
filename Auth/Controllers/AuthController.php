<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Controllers;

use Mindy\Base\Mindy;
use Modules\Auth\AuthModule;
use Modules\Auth\Forms\LoginForm;
use Modules\Core\Controllers\FrontendController;

class AuthController extends FrontendController
{
    public function actionLogin()
    {
        $request = $this->getRequest();

        $app = Mindy::app();
        if ($app->getUser()->getIsGuest() === false) {
            if (isset($_GET['_next'])) {
                $request->redirect($_GET['_next']);
            } else {
                $request->redirect($app->getUser());
            }
        }

        $form = new LoginForm();
        if ($request->getIsPost() && $form->populate($_POST)->isValid() && $form->login()) {
            if (isset($_GET['_next'])) {
                $request->redirect($_GET['_next']);
            } else {
                $request->redirect($app->getUser());
            }
        }

        echo $this->render('auth/login/form.html', [
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
            $this->redirectNext();
            $this->getRequest()->redirect(Mindy::app()->homeUrl);
        }

        $auth->logout();
        $this->getRequest()->redirect('auth:login');
    }

    public function redirectNext()
    {
        if (isset($_GET['_next'])) {
            $this->getRequest()->redirect($_GET['_next']);
        }
    }
}