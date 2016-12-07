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
 * @date 30/10/14.10.2014 15:20
 */

namespace Modules\Promo\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Promo\Forms\SubscribeForm;

class PromoController extends CoreController
{
    public function actionIndex()
    {
        $form = new SubscribeForm();
        if($this->r->isPost && $form->populate($_POST)->isValid()) {
            $form->save();
            echo $this->render('promo/success.html');
        } else {
            $module = Mindy::app()->getModule('Promo');
            echo $this->render('promo/index.html', [
                'form' => $form,
                'showForm' => $module->showForm
            ]);
        }
    }
}
