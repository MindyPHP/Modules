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

namespace Modules\Solutions\Controllers;

use Mindy\Orm\Model;
use Modules\Comments\Controllers\BaseCommentController;
use Modules\Comments\Models\BaseComment;
use Modules\Solutions\Models\Comment;
use Modules\Solutions\Models\Solution;

class CommentController extends BaseCommentController
{
    public $toLink = 'solution_id';

    /**
     * @return \Modules\Comments\Models\BaseComment
     */
    public function getModel()
    {
        return new Comment;
    }

    public function fetchModel($pk)
    {
        $model = Solution::objects()->filter(['pk' => $pk])->get();
        if ($model === null) {
            $this->error(404);
        }
        return $model;
    }

    public function actionView($pk)
    {
        $model = $this->fetchModel($pk);
        $this->internalActionList($model);
    }

    public function actionSave($pk)
    {
        $model = $this->fetchModel($pk);
        $this->internalActionSave($model);
    }

    /**
     * @param Model $model
     * @param \Mindy\Orm\Manager|\Mindy\Orm\QuerySet $qs
     * @return \Mindy\Orm\Manager|\Mindy\Orm\QuerySet
     */
    public function processComments(Model $model, $qs)
    {
        return $qs->filter(['solution' => $model]);
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
