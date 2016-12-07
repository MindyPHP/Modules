<?php

namespace Modules\User\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\User\Forms\ChangePasswordForm;
use Modules\User\Models\User;
use Modules\User\UserModule;

/**
 * Class UserController
 * @package Modules\User
 */
class UserController extends FrontendController
{
    public function allowedActions()
    {
        return ['index', 'view'];
    }

    public function beforeAction($owner, $action)
    {
        $user = Mindy::app()->getUser();

        if ($user->isGuest) {
            $this->getRequest()->redirect(Mindy::app()->getModule('user')->getLoginUrl());
        }

        if ($action->getId() == 'list' && $this->getModule()->userList === false && !$user->is_superuser) {
            $this->error(404);
        }

        return true;
    }

    public function actionView($username)
    {
        $model = User::objects()->filter(['username' => $username])->get();
        if ($model === null) {
            $this->error(404);
        }

        if ($model->username == Mindy::app()->user->username) {
            $this->getRequest()->redirect('user:profile');
        }

        if ($this->getModule()->userList) {
            $this->addBreadcrumb(UserModule::t("Users"), Mindy::app()->urlManager->reverse('user:list'));
        }
        $this->addBreadcrumb($model);

        echo $this->render('user/view.html', [
            'model' => $model
        ]);
    }

    public function actionIndex()
    {
        if ($this->getModule()->userList) {
            $this->addBreadcrumb(UserModule::t("Users"), Mindy::app()->urlManager->reverse('user:list'));
        }

        $qs = User::objects()->active();
        $pager = new Pagination($qs);
        echo $this->render('user/list.html', [
            'pager' => $pager,
            'models' => $pager->paginate()
        ]);
    }

    public function actionChangepassword()
    {
        $model = Mindy::app()->user;

        if ($this->getModule()->userList) {
            $this->addBreadcrumb(UserModule::t("Users"), Mindy::app()->urlManager->reverse('user:list'));
        }
        $this->addBreadcrumb($model, $model->getAbsoluteUrl());
        $this->addBreadcrumb(UserModule::t("Change password"));

        $form = new ChangePasswordForm([
            'model' => $model
        ]);

        if ($this->getRequest()->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->getRequest()->flash->success(UserModule::t('Password changed'));
            $this->getRequest()->redirect('user:login');
        }

        echo $this->render('user/change_password.html', [
            'form' => $form,
            'model' => $model
        ]);
    }
}
