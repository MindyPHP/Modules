<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 30/11/14 15:17
 */

namespace Modules\Clinic\Controllers;

use Modules\Core\Controllers\CoreController;
use Modules\Clinic\Models\Page;

class PageController extends CoreController
{
    public function actionDetail($pk)
    {
        $page = $this->getOr404(Page::className(), $pk);
        echo $this->render('clinic/page.html', [
            'model' => $page->department,
            'page' => $page
        ]);
    }
}
