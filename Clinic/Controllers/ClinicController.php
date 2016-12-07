<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 14:59
 */

namespace Modules\Clinic\Controllers;

use Modules\Clinic\Models\Category;
use Modules\Clinic\Models\Department;
use Modules\Core\Controllers\CoreController;
use Modules\Pages\Models\Page;

class ClinicController extends CoreController
{
    public function actionIndex()
    {
        echo $this->render('clinic/index.html');
    }

    public function actionDetail($pk)
    {
        $model = Department::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        echo $this->render('clinic/detail.html', [
            'model' => $model,
        ]);
    }

    public function actionPage($pk, $pagePk)
    {
        $model = Department::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        $page = Page::objects()->get(['pk' => $pagePk]);
        if ($page === null) {
            $this->error(404);
        }

        echo $this->render('clinic/page.html', [
            'model' => $model,
            'page' => $page,
        ]);
    }
}
