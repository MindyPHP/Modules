<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 11/05/16 12:02
 */

namespace Modules\User\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\FrontendController;
use Modules\User\Models\User;

/**
 * Class UserController
 * @package Modules\User
 */
class UserController extends FrontendController
{
    public function actionView($username)
    {
        $model = User::objects()->get(['username' => $username]);
        if ($model === null) {
            $this->error(404);
        }

        if ($model->username == Mindy::app()->user->username) {
            $this->getRequest()->redirect($this->getModule()->userRoute);
        }

        $this->addBreadcrumb($model);

        echo $this->render('user/view.html', [
            'model' => $model
        ]);
    }
}
