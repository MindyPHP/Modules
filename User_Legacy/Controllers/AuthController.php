<?php

namespace Modules\User\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;
use Modules\User\Forms\LoginForm;
use Modules\User\UserModule;

/**
 * Class AuthController
 * @package Modules\User
 */
class AuthController extends FrontendController
{
    public function actionLogin()
    {
        $request = $this->getRequest();

        $app = Mindy::app();
        if ($app->getUser()->getIsGuest() === false) {
            $request->redirect('user:profile');
        }

        $this->addBreadcrumb(UserModule::t("Login"));

        $form = new LoginForm();
        if ($request->getIsPost() && $form->populate($_POST)->isValid() && $form->login()) {
            $this->redirectNext();

            if ($request->getIsAjax()) {
                echo $this->json([
                    'status' => 'success',
                    'title' => UserModule::t('You have successfully logged in to the site')
                ]);
                Mindy::app()->end();
            } else {
                $request->redirect('user:profile');
            }
        }

        echo $this->render('user/login.html', [
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

        $auth->logout($this->getModule()->destroySessionAfterLogout);
        $this->getRequest()->redirect('user:login');
    }

    public function redirectNext()
    {
        if (isset($_GET['_next'])) {
            $this->getRequest()->redirect($_GET['_next']);
        }
    }
}
