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
use Modules\Classroom\Models\Classroom;
use Modules\Core\Controllers\FrontendController;
use Modules\User\Forms\LearnerProfileForm;
use Modules\User\Forms\TeacherProfileForm;
use Modules\User\Models\User;

class ProfileController extends FrontendController
{
    public function actionView()
    {
        $user = Mindy::app()->getUser();
        if ($user->getIsGuest()) {
            $this->error(403);
        }

        $this->addBreadcrumb('Личный кабинет');
        $classroom = Classroom::objects()->get(['administrator' => $user]);

        echo $this->render('user/profile/view.html', [
            'model' => $user,
            'classroom' => $classroom,
        ]);
    }

    public function actionUpdate()
    {
        $user = Mindy::app()->getUser();
        if ($user->getIsGuest()) {
            $this->error(403);
        }

        $this->addBreadcrumb('Личный кабинет', Mindy::app()->urlManager->reverse('main:user_profile'));
        $this->addBreadcrumb('Редактирование');

        $form = $this->dispatchProfileForm($user);
        $request = $this->getRequest();
        if ($request->getIsPost() && $form->populate($request->post->all()) && $form->isValid()) {
            $form->save();
        }

        echo $this->render('user/profile/form.html', [
            'model' => $user,
            'form' => $form,
        ]);
    }

    protected function dispatchProfileForm(User $user)
    {
        $params = [
            'instance' => $user
        ];
        return $user->is_staff ? new TeacherProfileForm($params) : new LearnerProfileForm($params);
    }
}