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
 * @date 12/09/14.09.2014 19:33
 */

namespace Modules\Forum\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\MarkdownField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Forum\ForumModule;
use Modules\User\Models\User;

class Topic extends Model
{
    public static function getFields()
    {
        return [
            'title' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => ForumModule::t('Title')
            ],
            'message' => [
                'class' => MarkdownField::className(),
                'verboseName' => ForumModule::t('Message')
            ],
            'forum' => [
                'class' => ForeignField::className(),
                'required' => true,
                'modelClass' => Forum::className(),
                'verboseName' => ForumModule::t('Forum')
            ],
            'is_sticky' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is sticky')
            ],
            'is_closed' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is closed')
            ],
            'is_locked' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is locked')
            ],
            'user' => [
                'class' => ForeignField::className(),
                'modelClass' => User::className(),
                'editable' => false,
                'verboseName' => ForumModule::t('User')
            ],
            'posts' => [
                'class' => HasManyField::className(),
                'modelClass' => Post::className(),
                'verboseName' => ForumModule::t('Posts'),
                'editable' => false
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
            'replies_count' => [
                'class' => IntField::className(),
                'length' => 11,
                'default' => 0,
                'verboseName' => ForumModule::t('Replies count'),
                'editable' => false
            ],
            'views_count' => [
                'class' => IntField::className(),
                'length' => 11,
                'default' => 0,
                'verboseName' => ForumModule::t('Views count'),
                'editable' => false
            ],
            'attachments' => [
                'class' => HasManyField::className(),
                'modelClass' => TopicAttachment::className(),
                'verboseName' => ForumModule::t('Attachments'),
            ],
            'is_published' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is published'),
                'default' => false
            ]
        ];
    }

    public function afterSave($owner, $isNew)
    {
        if ($isNew) {
            $owner->user = Mindy::app()->user;
            $owner->forum->topics_count += 1;
            $owner->forum->save(['topics_count']);
        }
    }

    public function afterDelete($owner)
    {
        $owner->forum->topics_count -= 1;
        $owner->forum->save(['topics_count']);

        $posts = $owner->posts->all();
        foreach($posts as $post) {
            $post->delete();
        }
    }

    public function __toString()
    {
        return (string)$this->title;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('forum:topic', [
            'pk' => $this->forum->pk,
            'slug' => $this->forum->slug,
            'id' => $this->pk
        ]);
    }
}
