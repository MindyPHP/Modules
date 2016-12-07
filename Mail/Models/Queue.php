<?php

/**
 * User: max
 * Date: 27/08/15
 * Time: 17:16
 */

namespace Modules\Mail\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Mail\MailModule;
use Modules\User\Models\User;

/**
 * Class Queue
 * @package Modules\Mail\Models
 * @method static \Modules\Mail\Models\QueueManager objects($instance = null)
 */
class Queue extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'user' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
                'verboseName' => self::t('User'),
                'editable' => false
            ],
            'subject' => [
                'class' => CharField::class,
                'verboseName' => self::t('Subject')
            ],
            'message_txt' => [
                'class' => TextField::class,
                'verboseName' => self::t('Message txt')
            ],
            'message_html' => [
                'class' => TextField::class,
                'verboseName' => self::t('Message html')
            ],
            'template' => [
                'class' => CharField::class,
                'verboseName' => self::t('Template'),
                // 'default' => 'mail/message'
                'default' => 'mail_template/index'
            ],
            'subscribers' => [
                'class' => ManyToManyField::class,
                'verboseName' => self::t('Subscribers'),
                'modelClass' => Subscribe::class
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'editable' => false,
                'verboseName' => self::t('Created at')
            ],
            'started_at' => [
                'class' => DateTimeField::class,
                'editable' => false,
                'verboseName' => self::t('Started at'),
                'null' => true
            ],
            'stopped_at' => [
                'class' => DateTimeField::class,
                'editable' => false,
                'verboseName' => self::t('Stopped at'),
                'null' => true
            ],
            'is_running' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is running'),
                'editable' => false,
            ],
            'is_complete' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is complete'),
                'editable' => false,
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new QueueManager($instance ? $instance : new $className);
    }

    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            $owner->user = Mindy::app()->getUser();
        }
    }

    public function beforeDelete($owner)
    {
        Mail::objects()->filter(['queue' => $owner])->delete();
    }

    public function getCount()
    {
        return Mail::objects()->filter(['is_sended' => false, 'queue' => $this])->count();
    }
}
