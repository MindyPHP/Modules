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
 * @date 27/08/14.08.2014 14:47
 */

namespace Modules\Reviews\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Mindy\Query\ConnectionManager;
use Modules\Reviews\ReviewsModule;
use Modules\User\Models\User;
use Mindy\Base\Mindy;

/**
 * Class Review
 * @package Modules\Reviews
 * @method static \Modules\Reviews\Models\ReviewManager objects($instance = null)
 */
class Review extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Name')
            ],
            'email' => [
                'class' => EmailField::class,
                'null' => true,
                'verboseName' => self::t('Email')
            ],
            'phone' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Phone')
            ],
            'content' => [
                'class' => TextField::class,
                'verboseName' => self::t('Content')
            ],
            'user' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
                'null' => true,
                'verboseName' => self::t('User')
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'default' => false,
                'verboseName' => self::t('Is published')
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'editable' => false,
                'verboseName' => self::t('Created time')
            ],
            'updated_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
                'editable' => false,
                'verboseName' => self::t('Updated time')
            ],
            'published_at' => [
                'class' => DateTimeField::class,
                'null' => true,
                'verboseName' => self::t('Published time')
            ],
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new ReviewManager($instance ? $instance : new $className);
    }

    public function getAbsoluteUrl()
    {
        return Mindy::app()->urlManager->reverse('reviews:view', ['pk' => $this->id]);
    }

    /**
     * @param $owner Review
     * @param $isNew
     */
    public function beforeSave($owner, $isNew)
    {
        if ($this->is_published && empty($owner->published_at)) {
            $queryBuilder = ConnectionManager::getDb()->getQueryBuilder();
            $owner->published_at = $queryBuilder->convertToDateTime();
        }
    }
}
