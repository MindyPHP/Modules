<?php

namespace Modules\Blog\Controllers;

use Mindy\Base\Mindy;
use Mindy\Orm\Q\OrQ;
use Mindy\Pagination\Pagination;
use Modules\Blog\BlogModule;
use Modules\Blog\Models\Post;
use Modules\Core\Controllers\FrontendController;

class PostController extends FrontendController
{
    public $defaultAction = 'view';

    /**
     * @param Post $model
     * @return string
     */
    protected function getView(Post $model)
    {
        return "blog/" . ($model->view ? $model->view : "post.html");
    }

    public function actionView($pk, $slug)
    {
        $qs = Post::objects()->filter([
            'pk' => $pk,
            'slug' => $slug
        ]);

        $cache = Mindy::app()->cache;
        if (($model = $cache->get('blog_post_' . $slug, null)) === null) {
            $model = $qs->get();
            if ($model === null) {
                $this->error(404);
            }
        }

        if (!$model->is_published && !Mindy::app()->getUser()->is_superuser) {
            $this->error(404);
        }

        $breadcrumbs = [
            ['name' => BlogModule::t('Blog'), 'url' => Mindy::app()->urlManager->reverse('blog:index')]
        ];
        if ($model->category) {
            $category = $model->category;
            $parents = $category->objects()->ancestors()->order(['lft'])->all();
            $parents[] = $category;
            foreach ($parents as $parent) {
                $breadcrumbs[] = [
                    'url' => $parent->getAbsoluteUrl(),
                    'name' => (string)$parent,
                ];
            }
        }
        $breadcrumbs[] = ['name' => (string)$model, 'url' => $model->getAbsoluteUrl()];

        echo $this->render($this->getView($model), [
            'model' => $model,
            'breadcrumbs' => $breadcrumbs,
            'hasComments' => $model->hasField('comments')
        ]);
    }

    public function actionIndex()
    {
        $breadcrumbs = [
            ['name' => BlogModule::t('Blog'), 'url' => Mindy::app()->urlManager->reverse('blog:index')]
        ];

        $qs = Post::objects()->published()->order(['-published_at']);
        $pager = new Pagination($qs);
        echo $this->render('blog/index.html', [
            'models' => $pager->paginate(),
            'pager' => $pager,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
