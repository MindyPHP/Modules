<?php
/**
 * Author: Falaleev Maxim
 * Email: max@studio107.ru
 * Company: http://en.studio107.ru
 * Date: 28/03/16
 * Time: 17:21
 */

namespace Modules\User\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;

/**
 * Class ProfileController
 * @package Modules\User\Controllers
 * @method \Modules\User\UserModule getModule
 */
class ProfileController extends FrontendController
{
    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'users' => ['@'],
                'actions' => ['view', 'update']
            ],
        ];
    }

    public function actionView()
    {
        $app = Mindy::app();
        $user = $app->getUser();
        if ($user->getIsGuest()) {
            $this->error(403);
        }

        echo $this->render('user/profile/view.html', [
            'model' => $user,
        ]);
    }

    public function actionUpdate()
    {
        $user = Mindy::app()->getUser();
        if ($user->getIsGuest()) {
            $this->error(403);
        }

        $form = $this->getModule()->getProfileForm();
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all()) && $form->isValid()) {
            $form->save();
        }

        echo $this->render('user/profile/form.html', [
            'model' => $user,
            'form' => $form,
        ]);
    }
}