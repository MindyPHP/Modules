<?php

namespace Modules\User\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BlobField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;

/**
 * Class Session
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 09/05/14.05.2014 14:00
 * @method static \Modules\User\Models\SessionManager objects()
 * @package Modules\User
 */
class Session extends Model
{
    public static function getFields()
    {
        return [
            'id' => [
                'class' => CharField::className(),
                'length' => 32,
                'primary' => true,
                'null' => false,
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'verboseName' => self::t('Created at')
            ],
            'expire' => [
                'class' => IntField::className(),
                'null' => false,
                'verboseName' => self::t("Expire time"),
            ],
            'data' => [
                'class' => BlobField::className(),
                'null' => true,
                'verboseName' => self::t("Session data"),
            ],
            'user' => [
                'class' => ForeignField::class,
                'verboseName' => self::t('User'),
                'modelClass' => User::class,
                'editable' => false,
                'null' => true
            ]
        ];
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new SessionManager($instance ? $instance : new $className);
    }

    public function beforeSave($owner, $isNew)
    {
        $owner->expire = time() + Mindy::app()->session->getTimeout();
        $owner->user = Mindy::app()->getUser();
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}
