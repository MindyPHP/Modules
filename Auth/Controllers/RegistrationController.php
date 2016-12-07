<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Controllers;

use Mindy\Helper\Creator;
use Modules\Auth\Forms\RegistrationForm;
use Modules\Core\Controllers\FrontendController;

/**
 * Class RegistrationController
 * @package Modules\User
 * @method \Modules\Auth\AuthModule getModule
 */
class RegistrationController extends FrontendController
{
    public function actionDispatch($profile = null)
    {
        $profiles = $this->getModule()->profiles;
        if (empty($profiles) || empty($profile) || !isset($profiles[$profile])) {
            $this->forward(self::class, 'index', [], $this->getModule());
        } else {
            $this->processForm($profiles[$profile]);
        }
    }

    protected function processForm($formClass)
    {
        $form = Creator::createObject([
            'class' => $this->getModule()->getRegistrationForm()
        ]);

        $profileForm = Creator::createObject([
            'class' => $formClass
        ]);

        $request = $this->getRequest();
        if ($request->getIsPost()) {
            $formValid = $form->populate($_POST)->isValid();
            $profileFormValid = $profileForm->populate($_POST)->isValid();
            if ($formValid && $profileFormValid) {
                if ($form->save() && $profileForm->setUser($form->getInstance())->save()) {
                    $request->flash->success($this->getModule()->t('You successfully registered'));
                    $request->redirect('auth:registration_success');
                } else {
                    $request->flash->success($this->getModule()->t('Error when registration. Please try again later.'));
                }
            } else {
                $request->flash->success($this->getModule()->t('Please fix validation errors'));
            }
        }

        echo $this->render('auth/registration/form.html', [
            'form' => $form,
            'profile_form' => $profileForm
        ]);
    }

    /**
     * Форма регистрации пользователя
     * @throws \Exception
     */
    public function actionIndex()
    {
        $profiles = $this->getModule()->profiles;
        if (count($profiles) > 0) {
            $this->error(404);
        }

        $form = Creator::createObject([
            'class' => $this->getModule()->getRegistrationForm()
        ]);

        $request = $this->getRequest();
        if ($request->getIsPost()) {
            if ($form->populate($_POST)->isValid()) {
                if ($form->save()) {
                    $request->flash->success($this->getModule()->t('You successfully registered'));
                    $request->redirect('auth:registration_success');
                } else {
                    $request->flash->success($this->getModule()->t('Error when registration. Please try again later.'));
                }
            } else {
                $request->flash->success($this->getModule()->t('Please fix validation errors'));
            }
        }

        echo $this->render('auth/registration/form.html', [
            'form' => $form
        ]);
    }

    /**
     * Сообщение об успешной регистрации пользователя
     */
    public function actionSuccess()
    {
        echo $this->render('auth/registration/success.html');
    }
}
