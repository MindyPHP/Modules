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
 * @date 03/11/14.11.2014 15:57
 */

namespace Modules\Forum\Controllers;

use Mindy\Base\Mindy;
use Modules\Core\Controllers\CoreController;
use Modules\Forum\Forms\PostForm;
use Modules\Forum\ForumModule;
use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Post;
use Modules\Forum\Models\Topic;

class PostController extends CoreController
{
    public function actionDelete($pk)
    {
        $model = Post::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }
        $topic = $model->topic;
        $model->delete();
        $this->r->redirect($topic);
    }

    public function actionReply($pk, $slug, $id)
    {
        $forum = Forum::objects()->filter(['slug' => $slug, 'pk' => $pk])->get();
        if ($forum === null) {
            $this->error(404);
        }

        $model = Topic::objects()->filter(['pk' => $id])->get();
        if ($model === null) {
            $this->error(404);
        }

        $urlManager = Mindy::app()->urlManager;
        $this->setCanonical($forum);
        $this->addTitle(ForumModule::t('Forum'));
        $this->addTitle($forum);
        $this->addTitle($model);
        $this->addTitle(ForumModule::t('Reply'));
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
            ['name' => (string)$forum, 'url' => $forum->getAbsoluteUrl()],
            ['name' => (string)$model, 'url' => $model->getAbsoluteUrl()],
            ['name' => ForumModule::t('Reply')]
        ]);

        $form = new PostForm();
        $form->setAttributes([
            'topic' => $model
        ]);
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->flash->success(ForumModule::t('Reply updated'));
            $this->r->redirect($form->getInstance());
        }

        echo $this->render('forum/post_update.html', [
            'model' => $model,
            'forum' => $forum,
            'form' => $form
        ]);
    }

    public function actionUpdate($pk)
    {
        $model = Post::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }
        $topic = $model->topic;
        $forum = $topic->forum;
        $urlManager = Mindy::app()->urlManager;
        $this->addTitle($forum);
        $this->addTitle($topic);
        $this->addTitle(ForumModule::t('Update topic: {name}', ['{name}' => $model]));
        $this->setBreadcrumbs([
            ['name' => ForumModule::t('Forum'), 'url' => $urlManager->reverse('forum:index')],
            ['name' => (string)$forum, 'url' => $forum->getAbsoluteUrl()],
            ['name' => (string)$topic, 'url' => $topic->getAbsoluteUrl()],
            ['name' => ForumModule::t('Update post: {name}', ['{name}' => $model])]
        ]);

        $form = new PostForm([
            'instance' => $model
        ]);
        $form->setAttributes([
            'topic' => $topic
        ]);
        if ($this->r->isPost && $form->populate($_POST)->isValid() && $form->save()) {
            $this->r->flash->success(ForumModule::t('Topic updated'));
            $this->r->redirect($form->getInstance());
        }

        echo $this->render('forum/post_update.html', [
            'forum' => $forum,
            'form' => $form,
            'model' => $model,
            'topic' => $topic
        ]);
    }
}
