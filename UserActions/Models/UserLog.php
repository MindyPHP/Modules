<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.1
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/01/15 17:29
 * @date 18/02/16 11:25
 */

namespace Modules\UserActions\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IpField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\User\Models\User;

class UserLog extends Model
{
    public $template = "{user} ({ip}): {message}";

    public static function getFields()
    {
        return [
            'user' => [
                'class' => ForeignField::class,
                'null' => true,
                'modelClass' => User::class,
                'verboseName' => self::t('User'),
            ],
            'ip' => [
                'class' => IpField::class,
                'null' => false,
                'verboseName' => self::t('Ip address')
            ],
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Message'),
                'null' => true
            ],
            'message' => [
                'class' => TextField::class,
                'verboseName' => self::t('Message')
            ],
            'module' => [
                'class' => CharField::class,
                'verboseName' => self::t('Module')
            ],
            'model' => [
                'class' => CharField::class,
                'verboseName' => self::t('Model'),
                'null' => true
            ],
            'url' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Url')
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'verboseName' => self::t('Created at')
            ]
        ];
    }

    public function __toString()
    {
        return (string)strtr($this->template, [
            '{module}' => $this->module,
            '{ip}' => $this->ip,
            '{user}' => $this->user,
            '{message}' => $this->message,
            '{model}' => $this->model,
            '{created_at}' => $this->created_at
        ]);
    }
}
