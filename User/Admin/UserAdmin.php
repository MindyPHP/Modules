<?php

namespace Modules\User\Admin;

use Mindy\Orm\Model;
use Modules\Admin\Admin\Admin;
use Modules\Auth\Forms\ChangePasswordForm;
use Modules\User\Forms\UserForm;
use Modules\User\Models\User;

/**
 * Class UserAdmin
 * @package Modules\User
 */
class UserAdmin extends Admin
{
    public $searchFields = ['username', 'email'];

    public $columns = [
        'username', 'email', 'is_staff',
        'is_superuser', 'last_login', 'created_at'
    ];

    public function getInfoFields(Model $model)
    {
        return ['id', 'username', 'email', 'is_staff', 'is_superuser', 'is_active', 'last_login'];
    }

    public function getCreateForm()
    {
        return UserForm::className();
    }

    public function getModelClass()
    {
        return User::class;
    }

    public function actionChangePassword($pk)
    {
        $model = User::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        $form = new ChangePasswordForm([
            'instance' => $model
        ]);

        $request = $this->getRequest();
        if ($request->getIsPost()) {
            if ($form->populate($_POST, $_FILES)->isValid()) {
                if ($form->save()) {
                    $this->afterCreate($form);
                    $request->flash->success('Данные успешно сохранены');

                    $next = $this->getNextRoute($_POST, $form);
                    if ($next) {
                        $request->redirect($next);
                    } else {
                        $request->refresh();
                    }
                } else {
                    $request->flash->error('При сохранении данных произошла ошибка, пожалуйста попробуйте выполнить сохранение позже или обратитесь к разработчику проекта, или вашему системному администратору');
                }
            } else {
                $request->flash->warning('Пожалуйста укажите корректные данные');
            }
        }

        echo $this->render($this->getTemplate('change_password.html'), [
            'model' => $model,
            'form' => $form,
            'breadcrumbs' => $this->fetchBreadcrumbs($model, 'change_password')
        ]);
    }

    public function getCustomBreadrumbs(Model $model, $action)
    {
        if ($action == 'change_password') {
            list(, , $update) = $model->getAdminNames($model);
            return [
                ['name' => $update, 'url' => $this->getAdminUrl('update', ['pk' => $model->pk])],
                ['name' => $this->getModule()->t('Change password')]
            ];
        }
        return parent::getCustomBreadrumbs($model, $action);
    }
}
