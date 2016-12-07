<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 23/01/15 18:27
 */

namespace Modules\Photo\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\FrontendController;
use Modules\Photo\Models\Album;

class AlbumController extends FrontendController
{
    public function actionIndex()
    {
        $module = $this->getModule();
        $this->addBreadcrumb($module->t('Gallery'));
        $this->setBreadcrumbs([
            ['name' => $module->t('Gallery')],
        ]);

        $qs = Album::objects();
        $pager = new Pagination($qs, [
            'pageSize' => 9
        ]);
        echo $this->render('photo/album/index.html', [
            'models' => $pager->paginate(),
            'pager' => $pager
        ]);
    }

    public function actionView($pk)
    {
        $model = Album::objects()->get(['pk' => $pk]);
        if ($model === null) {
            $this->error(404);
        }

        $urlManager = Mindy::app()->urlManager;
        $module = $this->getModule();
        $this->addBreadcrumb($module->t('Gallery'));
        $this->addBreadcrumb($model);
        $this->setBreadcrumbs([
            ['name' => $module->t('Gallery'), 'url' => $urlManager->reverse('photo:index')],
            ['name' => $model],
        ]);

        $pager = new Pagination($model->images, [
            'pageSize' => 9
        ]);
        echo $this->render('photo/album/view.html', [
            'model' => $model,
            'images' => $pager->paginate(),
            'pager' => $pager
        ]);
    }
}
