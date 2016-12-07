<?php

namespace Modules\Furniture\Controllers;

use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Furniture\Forms\RequestForm;
use Modules\Furniture\Models\Furniture;
use Modules\Furniture\Models\Request;

class FurnitureController extends CoreController
{
    public function actionList()
    {
        $pager = new Pagination(Furniture::objects());
        $furniture = $pager->paginate();
        echo $this->render('furniture/list.html', [
            'furniture' => $furniture,
            'pager' => $pager
        ]);
    }

    public function actionView($slug)
    {
        $item = Furniture::objects()->filter(['slug' => $slug])->get();
        if (!$item) {
            $this->error(404);
        }
        $form = new RequestForm();
        $form->setAttributes([
            'furniture' => $item->id
        ]);
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->flash->success('Вы успешно заказали товар! В ближайшее время с вами свяжется наш менеджер.');
            $this->redirect($item);
        }
        echo $this->render('furniture/view.html', [
            'item' => $item,
            'form' => $form
        ]);
    }
}