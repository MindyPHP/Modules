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

namespace Modules\Comments\Models;

use Mindy\Base\Mindy;
use Mindy\Helper\Text;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\TreeModel;
use Mindy\Query\ConnectionManager;
use Modules\Comments\CommentsModule;
use Modules\Comments\Components\Akismet\Akismet;
use Modules\User\Models\User;

abstract class BaseComment extends TreeModel
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'username' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => CommentsModule::t('Username')
            ],
            'email' => [
                'class' => EmailField::className(),
                'null' => true,
                'verboseName' => CommentsModule::t('Email')
            ],
            'user' => [
                'class' => ForeignField::className(),
                'modelClass' => User::className(),
                'null' => true,
                'verboseName' => CommentsModule::t('User')
            ],
            'is_spam' => [
                'class' => BooleanField::className(),
                'verboseName' => CommentsModule::t('Is spam')
            ],
            'is_published' => [
                'class' => BooleanField::className(),
                'default' => true,
                'verboseName' => CommentsModule::t('Is published')
            ],
            'comment' => [
                'class' => TextField::className(),
                'null' => false,
                'required' => true,
                'verboseName' => CommentsModule::t('Comment')
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'verboseName' => CommentsModule::t('Created at')
            ],
            'updated_at' => [
                'class' => DateTimeField::className(),
                'autoNow' => true,
                'verboseName' => CommentsModule::t('Updated at')
            ],
            'published_at' => [
                'class' => DateTimeField::className(),
                'editable' => false,
                'null' => true,
                'verboseName' => CommentsModule::t('Published at')
            ],
        ]);
    }

    public function beforeSave($owner, $isNew)
    {
        if ($owner->getIsNewRecord()){
            $akisment = Mindy::app()->getModule('Comments')->akisment;

            if (!Mindy::app()->getUser()->getIsGuest()) {
                $user = Mindy::app()->getUser();
                $owner->user = $user;
                $owner->email = $user->email;
                $owner->username = $user->username;
            }

            if (!empty($akisment) && count($akisment) == 2) {
                list($site, $key) = $akisment;

                $akismet = new Akismet($site, $key);
                if (!$akismet->isKeyValid()) {
                    Mindy::app()->logger->error('Invalid akisment key', 'comments');
                } else {
                    if ($user = $owner->user) {
                        $akismet->setCommentAuthor($user->username);
                        $akismet->setCommentAuthorEmail($user->email);
                        if (method_exists($user, 'getAbsoluteUrl')) {
                            $akismet->setCommentAuthorURL($this->wrapUrl($user->getAbsoluteUrl()));
                        }
                    } else {
                        $akismet->setCommentAuthor($owner->username);
                        $akismet->setCommentAuthorEmail($owner->email);
                        $akismet->setCommentAuthorURL(null);
                    }
                    $akismet->setCommentContent($owner->comment);
                    $akismet->setPermalink($owner->getRelationUrl());
                    $owner->is_spam = $akismet->isCommentSpam();
                    $owner->is_published = !$owner->is_spam && !$this->getIsPremoderate();
                }
            } else {
                $owner->is_published = !$this->getIsPremoderate();
            }
        }

        if ($owner->is_published) {
            $queryBuilder = ConnectionManager::getDb()->getQueryBuilder();
            /** @var \Mindy\Query\Pgsql\Lookup|\Mindy\Query\Mysql\Lookup $queryBuilder */

            if (empty($owner->published_at)) {
                $owner->published_at = $queryBuilder->convertToDateTime();
            } else {
                $owner->published_at = $queryBuilder->convertToDateTime($owner->published_at);
            }
        } else {
            $owner->published_at = null;
        }
    }

    protected function wrapUrl($url)
    {
        return Mindy::app()->request->http->absoluteUrl($url);
    }

    public function getIsPremoderate()
    {
        if (Mindy::app()->getUser()->is_superuser) {
            return false;
        };
        return Mindy::app()->getModule('Comments')->premoderate;
    }

    /**
     * @return BaseComment
     */
    abstract public function getRelation();

    public function getRelationUrl()
    {
        $relation = $this->getRelation();
        if (method_exists($relation, 'getAbsoluteUrl')) {
            return $this->wrapUrl($relation->getAbsoluteUrl());
        }

        return null;
    }

    /**
     * @param null $instance
     * @return \Mindy\Orm\TreeManager|CommentManager
     */
    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new CommentManager($instance ? $instance : new $className);
    }

    public function getName()
    {
        return $this->username . ":" . Text::limit($this->comment, 40);
    }
}
