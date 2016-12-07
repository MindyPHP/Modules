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
 * @date 11/09/14.09.2014 17:51
 */

namespace Modules\Solutions\Admin;

use Modules\Comments\Admin\BaseCommentAdmin;
use Modules\Solutions\Models\Comment;

class CommentAdmin extends BaseCommentAdmin
{
    public function getColumns()
    {
        return ['id', 'username', 'email', 'created_at', 'is_published'];
    }
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Comment;
    }
}
