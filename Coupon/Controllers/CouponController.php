<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 21/08/14.08.2014 19:31
 */

namespace Modules\Coupon\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Coupon\Forms\CouponForm;

class CouponController extends CoreController
{
    public function actionIndex()
    {
        $app = Mindy::app();
        $request = $app->request;

        $form = new CouponForm();
        if($request->isPostRequest && $form->setAttributes($_POST)->isValid() && $form->save()) {
            $form->send();

            $app->flash->success('Купон отправлен');
            $this->redirectNext();

            $this->setBreadcrumbs([
                ['name' => 'Заявка на купон успешно принята']
            ]);

            echo $this->render('coupon/success.html', ['model' => $form->instance]);
        } else {
            $this->setBreadcrumbs([
                ['name' => 'Заявка на купон']
            ]);

            echo $this->render('coupon/form.html', ['form' => $form]);
        }
    }
}
