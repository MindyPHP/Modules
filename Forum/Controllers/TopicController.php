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
 * @date 14/10/14.10.2014 17:27
 */

namespace Modules\Forum\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Core\Controllers\CoreController;
use Modules\Forum\Forms\PostForm;
use Modules\Forum\Forms\TopicForm;
use Modules\Forum\Forms\TopicReplyForm;
use Modules\Forum\ForumModule;
use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Topic;

class TopicController extends CoreController
{
    public function actionView($pk, $slug, $id)
    {
        $forum = Forum::objects()->filter(['slug' => $slug, 'pk' => $pk])->get();
        if ($forum === null) {
            $this->error(404);
        }

        $model = Topic::objects()->filter(['forum' => $forum, 'pk' => $id, 'is_published' => true])->get();
        if ($model === null) {
            $this->error(404);
        }
        $model->views_count += 1;
        $model->save(['views_count']);

        $urlManager = Mindy::app()->urlManager;
        $this->setCanonical($forum);
        $this->addTitle(ForumModule::t('Forum'));
        $this->addTitle($forum);
        $this->addTitle($model);
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
            ['name' => (string)$forum, 'url' => $forum->getAbsoluteUrl()],
            ['name' => (string)$model, 'url' => $model->getAbsoluteUrl()],
        ]);

        $form = new PostForm();
        $form->setAttributes([
            'topic' => $model
        ]);

        $pager = new Pagination($model->posts->filter(['is_published' => true]));
        echo $this->render('forum/topic_view.html', [
            'forum' => $forum,
            'model' => $model,
            'pager' => $pager,
            'posts' => $pager->paginate(),
            'form' => $form
        ]);
    }

    public function actionAdd($pk, $slug)
    {
        $forum = Forum::objects()->filter(['slug' => $slug, 'pk' => $pk])->get();
        if ($forum === null) {
            $this->error(404);
        }

        $urlManager = Mindy::app()->urlManager;
        $this->setCanonical($forum);
        $this->addTitle(ForumModule::t('Forum'));
        $this->addTitle($forum);
        $this->addTitle(ForumModule::t('Add topic'));
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
            ['name' => (string)$forum, 'url' => $forum->getAbsoluteUrl()],
            ['name' => ForumModule::t('Add topic')]
        ]);

        $form = new TopicForm();
        $form->setAttributes([
            'forum' => $forum
        ]);
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->flash->success(ForumModule::t('Topic created'));
            $this->r->redirect($form->getInstance());
        }

        echo $this->render('forum/topic_add.html', [
            'forum' => $forum,
            'form' => $form
        ]);
    }

    public function actionUpdate($pk)
    {
        $model = Topic::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }
        $forum = $model->forum;
        $urlManager = Mindy::app()->urlManager;
        $this->addTitle(ForumModule::t('Update topic: {name}', ['{name}' => $model]));
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
            ['name' => (string)$forum, 'url' => $forum->getAbsoluteUrl()],
            ['name' => ForumModule::t('Update topic: {name}', ['{name}' => $model])]
        ]);

        $form = new TopicForm([
            'instance' => $model
        ]);
        $form->setAttributes([
            'forum' => $forum
        ]);
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->flash->success(ForumModule::t('Topic updated'));
            $this->r->redirect($form->getInstance());
        }

        echo $this->render('forum/topic_update.html', [
            'forum' => $forum,
            'form' => $form,
            'model' => $model
        ]);
    }

    public function actionDelete($pk)
    {
        $model = Topic::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }
        $forum = $model->forum;
        $model->delete();
        $this->r->redirect($forum);
    }

    public function actionNewThreads()
    {
        $urlManager = Mindy::app()->urlManager;
        $module = $this->getModule();
        $this->addBreadcrumb($module->t('Forum'), $urlManager->reverse('forum:index'));
        $this->addBreadcrumb($module->t('New threads'));
        $this->addTitle($module->t('Forum'));
        $this->addTitle($module->t('New threads'));

        $qs = Topic::objects()->order(['-created_at']);
        $pager = new Pagination($qs);
        echo $this->render('forum/new_threads.html', [
            'pager' => $pager,
            'models' => $pager->paginate(),
        ]);
    }
}
