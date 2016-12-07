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
 * @date 30/10/14.10.2014 17:29
 */

namespace Modules\Wiki\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Wiki\Forms\CreateWikiForm;
use Modules\Wiki\Forms\WikiForm;
use Modules\Wiki\Models\Wiki;
use Modules\Wiki\WikiModule;

class WikiController extends CoreController
{
    public function actionIndex()
    {
        $this->addBreadcrumb(WikiModule::t('Wiki'), Mindy::app()->urlManager->reverse('wiki:index'));
        $this->addBreadcrumb(WikiModule::t("Index"));
        $this->addTitle(WikiModule::t("Index"));

        $models = Wiki::objects()->asArray()->all();
        usort($models, function($a, $b) {
            return mb_strlen($b['url'], 'utf-8') < mb_strlen($a['url'], 'utf-8');
        });
        echo $this->render('wiki/index.html', [
            'models' => $models
        ]);
    }

    public function actionView($url = null)
    {
        $model = Wiki::objects()->filter(['url' => $url])->get();
        $this->addBreadcrumb(WikiModule::t('Wiki'), Mindy::app()->urlManager->reverse('wiki:index'));
        if ($model === null) {
            $this->addBreadcrumb(WikiModule::t('Create page: {url}', ['{url}' => $url]));
            $this->setTitle(WikiModule::t('Create page: {url}', ['{url}' => $url]));
            $this->setCanonical(Mindy::app()->urlManager->reverse('wiki:view', ['url' => $url]));

            $form = new CreateWikiForm();
            $form->setAttributes(['url' => $url]);
            if ($this->r->isPost && $form->populate($_POST)->isValid()) {
                $form->save();
                $this->r->redirect($form->getInstance());
            }
            echo $this->render('wiki/create.html', [
                'form' => $form,
                'url' => $url
            ]);
        } else {
            $this->addBreadcrumb($model);
            $this->setTitle($model);
            $this->setCanonical($model);

            echo $this->render('wiki/view.html', [
                'model' => $model,
                'url' => $url
            ]);
        }
    }

    public function actionUpdate($url)
    {
        $model = Wiki::objects()->filter(['url' => $url])->get();
        if ($model === null) {
            $this->error(404);
        }

        $this->addBreadcrumb(WikiModule::t('Wiki'), Mindy::app()->urlManager->reverse('wiki:index'));
        $this->addBreadcrumb(WikiModule::t("Update: {url}", ['{url}' => $model]));

        $form = new WikiForm(['instance' => $model]);
        if ($this->r->isPost && $form->populate($_POST)->isValid()) {
            $form->save();
            $this->r->redirect($form->getInstance());
        }

        echo $this->render('wiki/update.html', [
            'model' => $model,
            'form' => $form
        ]);
    }
}
