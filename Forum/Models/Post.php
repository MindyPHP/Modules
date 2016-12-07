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
 * @date 14/10/14.10.2014 17:33
 */

namespace Modules\Forum\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\MarkdownField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Forum\ForumModule;
use Modules\User\Models\User;

class Post extends Model
{
    public static function getFields()
    {
        return [
            'content' => [
                'class' => MarkdownField::className(),
                'verboseName' => ForumModule::t('Reply')
            ],
            'topic' => [
                'class' => ForeignField::className(),
                'modelClass' => Topic::className(),
                'verboseName' => ForumModule::t('Topic')
            ],
            'user' => [
                'class' => ForeignField::className(),
                'modelClass' => User::className(),
                'editable' => false,
                'verboseName' => ForumModule::t('User')
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'editable' => false
            ],
            'updated_at' => [
                'class' => DateTimeField::className(),
                'autoNow' => true,
                'editable' => false
            ],
            'is_published' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is published'),
                'default' => false
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->content;
    }

    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            $owner->user = Mindy::app()->user;
            $topic = $owner->topic;
            $topic->replies_count += 1;
            $topic->save(['replies_count']);

            $forum = $topic->forum;
            $forum->replies_count += 1;
            $forum->save(['replies_count']);
        }
    }

    public function afterDelete($owner)
    {
        $topic = $owner->topic;
        $topic->replies_count -= 1;
        $topic->save(['replies_count']);

        $forum = $topic->forum;
        $forum->replies_count -= 1;
        $forum->save(['replies_count']);
    }

    public function getAbsoluteUrl()
    {
        return $this->topic->getAbsoluteUrl() . '#' . $this->pk;
    }
}
