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
 * @date 17/11/14.11.2014 15:51
 */

namespace Modules\Mail\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Model;

class Subscribe extends Model
{
    public static function getFields()
    {
        return [
            'email' => [
                'class' => EmailField::class,
                'verboseName' => self::t('Email'),
                'unique' => true
            ],
            'token' => [
                'class' => CharField::class,
                'verboseName' => self::t('Token'),
                'editable' => false,
                'null' => true,
                'length' => 10
            ],
            'name' => [
                'class' => CharField::class,
                'null' => true,
                'verboseName' => self::t('Name')
            ],
        ];
    }

    public function __toString()
    {
        return (string)strtr('{name} {email}', [
            '{name}' => $this->name,
            '{email}' => $this->email
        ]);
    }

    /**
     * @param $owner Model
     * @param $isNew
     */
    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            $this->token = substr(md5(microtime()), 0, 10);
        }
    }
}