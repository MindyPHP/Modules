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
 * @date 14/10/14.10.2014 17:23
 */

namespace Modules\Forum\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Forum\ForumModule;
use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Topic;

class ForumController extends CoreController
{
    public function actionIndex()
    {
        $urlManager = Mindy::app()->urlManager;
        $this->setCanonical($urlManager->reverse('forum:index'));
        $this->addTitle(ForumModule::t('Forum'));
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
        ]);

        $models = Forum::objects()->roots()->order(['root', 'lft'])->all();
        echo $this->render('forum/index.html', [
            'models' => $models,
        ]);
    }

    public function actionForum($pk, $slug)
    {
        $model = Forum::objects()->filter([
            'pk' => $pk,
            'slug' => $slug
        ])->get();

        if ($model === null) {
            $this->error(404);
        }

        $urlManager = Mindy::app()->urlManager;
        $this->setCanonical($model);
        $this->addTitle(ForumModule::t('Forum'));
        $this->addTitle($model);
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
            ['name' => (string) $model, 'url' => $model->getAbsoluteUrl()]
        ]);

        $topics = Topic::objects()->filter(['forum' => $model, 'is_published' => true]);
        $pager = new Pagination($topics);
        echo $this->render('forum/view.html', [
            'model' => $model,
            'topics' => $pager->paginate(),
            'pager' => $pager,
        ]);
    }
}
