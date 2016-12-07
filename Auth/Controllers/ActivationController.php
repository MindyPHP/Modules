<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\Auth\Controllers;

use Mindy\Base\Mindy;
use Modules\Auth\Forms\Activation\EmailForm;
use Modules\Auth\Forms\Activation\SmsConfirmForm;
use Modules\Auth\Forms\Activation\SmsForm;
use Modules\Auth\Models\ActivationKey;
use Modules\Core\Controllers\FrontendController;

/**
 * Class ActivationController
 * @package Modules\Auth\Controllers
 */
class ActivationController extends FrontendController
{
    /**
     * Процедура активации аккаунта: финальный этап
     * Проверяются возможные типы активации: по email или sms.
     * В случае смс предварительно выполняется @see ActivationController::actionConfirm($type)
     * @param $type
     * @throws \Mindy\Exception\HttpException
     */
    public function actionProcess($type)
    {
        if (in_array($type, ['email', 'sms']) === false) {
            $this->error(404);
        }

        $key = $this->getRequest()->get->get('key');

        /**
         * Если код пуст, отображаем сообщение о не корректно присланном коде
         */
        if (empty($key)) {
            echo $this->render(strtr('auth/activation/empty.html', ['{type}' => $type]));
            Mindy::app()->end();
        }

        /**
         * Ищем активный (последний отправленный) код
         */
        $model = ActivationKey::objects()->get(['key' => $key, 'type' => $type, 'is_active' => true]);
        if ($model === null) {
            echo $this->render(strtr('auth/activation/incorrect.html', ['{type}' => $type]));
            Mindy::app()->end();
        }

        /**
         * Если пользователь уже активирован, сообщаем ему об этом
         */
        $user = $model->user;
        if ($user->is_active) {
            echo $this->render(strtr('auth/activation/already.html', ['{type}' => $type]));
            Mindy::app()->end();
        }

        /**
         * Если ключи совпадают, удаляем ключ и активируем учетную запись пользователя
         */
        if ($model->key === $key) {
            $model->delete();
            $user->is_active = true;
            $user->save(['is_active']);

            echo $this->render(strtr('auth/activation/success.html', ['{type}' => $type]));
        } else {
            echo $this->render(strtr('auth/activation/failed.html', ['{type}' => $type]));
        }
    }

    /**
     * Проверка активационного кода полученного по смс
     * @param $type
     * @throws \Exception
     * @throws \Mindy\Exception\HttpException
     */
    public function actionConfirm($type)
    {
        if ($type == 'email') {
            $this->error(404);
        }

        $request = $this->getRequest();
        $form = new SmsConfirmForm;
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid()) {
            $key = $form->getKey();
            $url = Mindy::app()->urlManager->reverse('auth:activation_activate', ['type' => $type]) . '?' . http_build_query(['key' => $key]);
            $request->redirect($url);
        }

        echo $this->render(strtr('auth/activation/{type}/form.html', ['{type}' => $type]), [
            'form' => $form
        ]);
    }

    public function actionForm($type)
    {
        if (in_array($type, ['email', 'sms']) === false) {
            $this->error(404);
        }

        $form = $type == 'email' ? new EmailForm() : new SmsForm();
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid() && $form->save()) {
            if ($type == 'email') {
                $request->redirect(Mindy::app()->urlManager->reverse('auth:activation_sended', ['type' => $type]));
            } else {
                $request->redirect(Mindy::app()->urlManager->reverse('auth:activation', ['type' => $type]));
            }
        }
        echo $this->render(strtr('auth/activation/{type}/form.html', ['{type}' => $type]), [
            'form' => $form
        ]);
    }

    public function actionSended($type)
    {
        echo $this->render('auth/activation/sended.html', [
            'type' => $type
        ]);
    }
}