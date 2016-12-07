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
 * @date 11/09/14.09.2014 12:36
 */

namespace Modules\Blog\Controllers;

use Mindy\Base\Mindy;
use Mindy\Orm\Model;
use Modules\Blog\Models\Comment;
use Modules\Blog\Models\Post;
use Modules\Comments\Controllers\BaseCommentController;
use Modules\Comments\Models\BaseComment;

class CommentController extends BaseCommentController
{
    public $toLink = 'post_id';

    /**
     * @return \Modules\Comments\Models\BaseComment
     */
    public function getModel()
    {
        return new Comment;
    }

    public function fetchModel($pk, $slug)
    {
        $qs = Post::objects()->published()->filter([
            'pk' => $pk,
            'slug' => $slug
        ]);
        $cache = Mindy::app()->cache;
        if ($model = $cache->get('blog_post_' . $slug . '_comments', null) === null) {
            if (($model = $qs->get()) === null) {
                $this->error(404);
            }
        }
        return $model;
    }

    public function getTemplate($name = null)
    {
        return 'blog/_comments.html';
    }

    public function actionView($pk, $slug)
    {
        $this->internalActionList($this->fetchModel($pk, $slug));
    }

    public function actionSave($pk, $slug)
    {
        $this->internalActionSave($this->fetchModel($pk, $slug));
    }

    /**
     * @param Model $model
     * @param \Mindy\Orm\Manager|\Mindy\Orm\QuerySet $qs
     * @return \Mindy\Orm\Manager|\Mindy\Orm\QuerySet
     */
    public function processComments(Model $model, $qs)
    {
        return $qs->filter(['post' => $model]);
    }

    /**
     * @param Comment $model
     * @return Comment
     */
    public function processComment(BaseComment $model)
    {
        return $model;
    }
}
