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
 * @date 12/09/14.09.2014 19:28
 */

namespace Modules\Forum\Models;


use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\TreeModel;
use Modules\Forum\ForumModule;
use Modules\User\Models\User;

class Forum extends TreeModel
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => ForumModule::t('Name')
            ],
            'slug' => [
                'class' => SlugField::className(),
                'verboseName' => ForumModule::t('Slug')
            ],
            'description' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => ForumModule::t('Content')
            ],
            'is_sticky' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is sticky')
            ],
            'is_closed' => [
                'class' => BooleanField::className(),
                'verboseName' => ForumModule::t('Is closed')
            ],
            'topics_count' => [
                'class' => IntField::className(),
                'length' => 11,
                'default' => 0,
                'verboseName' => ForumModule::t('Topics count'),
                'editable' => false
            ],
            'replies_count' => [
                'class' => IntField::className(),
                'length' => 11,
                'default' => 0,
                'verboseName' => ForumModule::t('Replies count'),
                'editable' => false
            ],
            'user' => [
                'class' => ForeignField::className(),
                'modelClass' => User::className(),
                'editable' => false,
                'verboseName' => ForumModule::t('User')
            ],
        ]);
    }

    public function beforeSave($owner, $isNew)
    {
        $owner->user = Mindy::app()->user;
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('forum:forum', ['pk' => $this->pk, 'slug' => $this->slug]);
    }
}
