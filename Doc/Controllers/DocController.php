<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 20/01/15 14:29
 */

namespace Modules\Doc\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Doc\Models\Page;

class DocController extends CoreController
{
    public function actionIndex()
    {
        $urlManager = Mindy::app()->urlManager;
        $module = $this->getModule();

        $this->setCanonical($urlManager->reverse('doc:index'));
        $this->addTitle($module->t('Docs'));
        $this->addBreadcrumb($module->t('Docs'), $urlManager->reverse('doc:index'));

        $models = Page::objects()->order(['root', 'lft'])->all();
        echo $this->render('doc/page/index.html', [
            'models' => $models
        ]);
    }

    public function actionView($url)
    {
        $model = Page::objects()->get(['url' => $url]);
        if ($model === null) {
            $this->error(404);
        }

        $this->setCanonical($model);
        $urlManager = Mindy::app()->urlManager;
        $module = $this->getModule();
        $this->addTitle($model);
        $this->addBreadcrumb($module->t('Docs'), $urlManager->reverse('doc:index'));
        $this->fetchBreadrumbs($model);

        if ($model->isLeaf() === false) {
            echo $this->render('doc/page/list.html', [
                'model' => $model,
                'models' => $model->objects()->children()->order(['root', 'lft'])->all()
            ]);
        } else {
            $prev = $model->objects()->prev()->get();
            $next = $model->objects()->next()->get();
            echo $this->render('doc/page/view.html', [
                'model' => $model,
                'prev' => $prev,
                'next' => $next
            ]);
        }
    }

    protected function fetchBreadrumbs(Page $model)
    {
        /** @var Page[] $pages */
        $pages = $model->tree()->ancestors()->order(['level'])->all();
        foreach ($pages as $page) {
            $this->addTitle($page->name);
            $this->addBreadcrumb($page->name, $page->getAbsoluteUrl());
        }
        $this->addTitle($model->name);
        $this->addBreadcrumb($model->name, $model->getAbsoluteUrl());
    }
}
