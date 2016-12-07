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
 * @date 11/09/14.09.2014 12:34
 */

namespace Modules\Blog\Models;

use Mindy\Orm\Fields\ForeignField;
use Modules\Comments\Models\BaseComment;

/**
 * Class Comment
 * @package Modules\Comments
 * @method static \Modules\Comments\Models\CommentManager objects($instance = null)
 */
class Comment extends BaseComment
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'post' => [
                'class' => ForeignField::class,
                'modelClass' => Post::class,
                'verboseName' => self::t('Blog post')
            ]
        ]);
    }

    /**
     * @return BaseComment
     */
    public function getRelation()
    {
        return $this->post;
    }
}
