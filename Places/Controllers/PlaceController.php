<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 18:01
 */

namespace Modules\Places\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Places\Models\Place;

class PlaceController extends CoreController
{
    public function actionList()
    {
        $this->addBreadcrumb($this->getModule()->t('Places'));
        $this->addTitle($this->getModule()->t('Places'));

        $qs = Place::objects();
        echo $this->render('places/list.html', [
            'models' => $qs->all(),
        ]);
    }

    public function actionDetail($pk)
    {
        $model = Place::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        $this->addBreadcrumb($this->getModule()->t('Places'), Mindy::app()->urlManager->reverse('places.list'));
        $this->addBreadcrumb($model);

        $this->addTitle($this->getModule()->t('Places'));
        $this->addTitle($model);

        echo $this->render('places/detail.html', [
            'model' => $model
        ]);
    }

    public function actionMap($pk)
    {
        $model = Place::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        echo $this->render('places/map.html', [
            'model' => $model
        ]);
    }
}
