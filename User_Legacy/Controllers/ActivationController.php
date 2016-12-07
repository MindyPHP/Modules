<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 29/03/16
 * Time: 17:13
 */

namespace Modules\User\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;
use Modules\User\Forms\Activation\EmailForm;
use Modules\User\Forms\Activation\SmsForm;
use Modules\User\Forms\Activation\SmsConfirmForm;
use Modules\User\UserModule;

class ActivationController extends FrontendController
{
    public function actionEmail()
    {
        $this->setBreadcrumbs([
            ['name' => UserModule::t('Login'), 'url' => Mindy::app()->urlManager->reverse('user:login')],
            ['name' => 'Повторная отправка электронного письма для активации учетной записи']
        ]);

        $form = new EmailForm();
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid() && $form->send()) {
            $request->redirect(Mindy::app()->urlManager->reverse('user:activation_email_success'));
        }
        echo $this->render('user/activation/email.html', ['form' => $form]);
    }

    public function actionEmailSuccess()
    {
        $this->setBreadcrumbs([
            ['name' => 'Ваша учетная запись успешно активирована']
        ]);

        echo $this->render('user/activation/email_success.html');
    }

    public function actionSms()
    {
        $this->setBreadcrumbs([
            ['name' => UserModule::t('Login'), 'url' => Mindy::app()->urlManager->reverse('user:login')],
            ['name' => 'Повторная отправка SMS для активации учетной записи']
        ]);

        $form = new SmsForm();
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid() && $form->send()) {
            $request->redirect(Mindy::app()->urlManager->reverse('user:activation_sms_сonfirm'));
        }
        echo $this->render('user/activation/sms.html', ['form' => $form]);
    }

    public function actionSmsConfirm()
    {
        $this->setBreadcrumbs([
            ['name' => UserModule::t('Login'), 'url' => Mindy::app()->urlManager->reverse('user:login')],
            ['name' => 'Повторная отправка SMS для активации учетной записи', 'url' => Mindy::app()->urlManager->reverse('user:activation_sms')],
            ['name' => 'Подтверждение учетной записи по смс']
        ]);

        $form = new SmsConfirmForm();
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid() && $form->activate()) {
            $request->redirect(Mindy::app()->urlManager->reverse('user:activation_sms_success'));
        }
        echo $this->render('user/activation/sms_confirm.html', ['form' => $form]);
    }

    public function actionSmsSuccess()
    {
        $this->setBreadcrumbs([
            ['name' => 'Ваша учетная запись успешно активирована']
        ]);

        echo $this->render('user/activation/sms_success.html');
    }
}