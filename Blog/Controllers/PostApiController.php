<?php

/**
 * User: max
 * Date: 31/07/15
 * Time: 20:52
 */

namespace Modules\Blog\Controllers;

use Mindy\Base\Mindy;
use Mindy\Pagination\Pagination;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Core\Controllers\ApiBaseController;

class PostApiController extends ApiBaseController
{
    public function actionIndex()
    {
        $slug = $this->getRequest()->get->get('slug');
        $cacheKey = 'blog_api_index_' . $slug;
        $cache = Mindy::app()->cache;
        $data = $cache->get($cacheKey);
        if (!$data) {
            if (!empty($slug)) {
                $category = Category::objects()->asArray()->get(['slug' => $slug]);
                if ($category === null) {
                    $this->error(404);
                }
            } else {
                $category = null;
            }

            $qs = Post::objects()->published()->with(['category'])->asArray();
            if ($slug) {
                $qs->filter(['category_id' => $category['id']]);
            }
            $pager = new Pagination($qs);
            $pager->paginate();
            $data = $pager->toJson();
            $data['category'] = $category;

            $cache->set($cacheKey, $data, 3600);
        }

        echo $this->json($data);
        $this->end();
    }

    public function actionView($pk, $slug)
    {
        $qs = Post::objects()
            ->published()
            ->with(['category'])
            ->asArray()
            ->filter([
                'pk' => $pk,
                'slug' => $slug
            ]);

        $cache = Mindy::app()->cache;
        $data = $cache->get('blog_post_api_' . $slug);
        if (!$data) {
            $model = $qs->get();

            if ($model === null) {
                $this->error(404);
            }

            $data = [
                'model' => $model
            ];
            $cache->set('blog_post_api_' . $slug, $data, 3600);
        }

        echo $this->json($data);
        $this->end();
    }
}
