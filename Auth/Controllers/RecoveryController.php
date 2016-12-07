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
use Modules\Auth\Forms\Recovery\EmailForm;
use Modules\Auth\Forms\Recovery\SmsConfirmForm;
use Modules\Auth\Forms\Recovery\SmsForm;
use Modules\Auth\Models\LostPasswordKey;
use Modules\Core\Controllers\FrontendController;

class RecoveryController extends FrontendController
{
    protected function hasSmsModule()
    {
        return Mindy::app()->hasModule('Sms');
    }

    public function actionForm($type)
    {
        if (in_array($type, ['email', 'sms']) == false) {
            $this->error(404);
        }

        if ($this->hasSmsModule() == false && $type == 'sms') {
            $this->error(404);
        }

        $request = $this->getRequest();
        $form = $type == 'email' ? new EmailForm() : new SmsForm;
        if ($request->getIsPost()) {
            if ($form->populate($_POST)->isValid() && $form->save()) {
                if ($type == 'email') {
                    $request->flash->success($this->getModule()->t('Link to recovery password successfully sent to your email address'));
                    $request->refresh();
                } else {
                    $request->redirect('auth:recovery_confirm', ['type' => $type]);
                }
            } else {
                $request->flash->error($this->getModule()->t('Error. Please try again later.'));
            }
        }

        echo $this->render(strtr('auth/recovery/{type}/form.html', ['{type}' => $type]), [
            'form' => $form
        ]);
    }

    public function actionConfirm($type)
    {
        if ($type == 'email') {
            $this->error(404);
        }

        if ($this->hasSmsModule() == false && $type == 'sms') {
            $this->error(404);
        }

        $request = $this->getRequest();
        $form = new SmsConfirmForm;
        if ($request->getIsPost() && $form->populate($request->post->all())->isValid()) {
            $key = $form->getKey();
            $url = Mindy::app()->urlManager->reverse('auth:recovery_process', ['type' => $type]) . '?' . http_build_query(['key' => $key]);
            $request->redirect($url);
        }

        echo $this->render(strtr('auth/activation/{type}/form.html', ['{type}' => $type]), [
            'form' => $form
        ]);
    }

    /**
     * Процедура восстановления доступа к аккаунту: финальный этап
     * Проверяются возможные типы активации: по email или sms.
     * В случае смс предварительно выполняется @see RecoveryController::actionConfirm($type)
     * @param $type
     * @throws \Mindy\Exception\HttpException
     */
    public function actionProcess($type)
    {
        if (in_array($type, ['email', 'sms']) === false) {
            $this->error(404);
        }

        if ($this->hasSmsModule() == false && $type == 'sms') {
            $this->error(404);
        }

        $key = $this->getRequest()->get->get('key');

        /*
         * Если код пуст, отображаем сообщение о не корректно присланном коде
         */
        if (empty($key)) {
            echo $this->render(strtr('auth/activation/empty.html', ['{type}' => $type]));
            Mindy::app()->end();
        }

        /*
         * Ищем активный (последний отправленный) код
         */
        $model = LostPasswordKey::objects()->get(['key' => $key, 'type' => $type, 'is_active' => true]);
        if ($model === null) {
            echo $this->render(strtr('auth/activation/incorrect.html', ['{type}' => $type]));
            Mindy::app()->end();
        }

        /*
         * Если ключи совпадают, удаляем ключ и активируем учетную запись пользователя
         */
        if ($model->key === $key) {
            $form = new ChangePasswordForm([
                'checkCurrentPassword' => false,
                'instance' => $model->user
            ]);

            $request = $this->getRequest();
            if ($request->getIsPost() && $form->populate($_POST)->isValid() && $form->save()) {
                // Удаление ключей во избежание переиспользования или повторной смены пароля
                LostPasswordKey::objects()->filter(['user' => $model->user])->delete();

                $request->flash->success($this->getModule()->t('Password successfully changed'));
                $request->redirect('auth:login');
            }

            echo $this->render(strtr('auth/password/form.html', ['{type}' => $type]), [
                'form' => $form
            ]);
        } else {
            echo $this->render(strtr('auth/recovery/{type}/failed.html', ['{type}' => $type]));
        }
    }
}