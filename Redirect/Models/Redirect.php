<?php

namespace Modules\Redirect\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;

/**
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 14/04/14.04.2014 15:11
 */

class Redirect extends Model
{
    public function __toString()
    {
        return strtr("{from} - {to} ({status})", [
            '{from}' => $this->from_url,
            '{to}' => $this->to_url,
            '{status}' => $this->status
        ]);
    }

    public static function getFields()
    {
        return [
            'from_url' => [
                'class' => CharField::class,
                'verboseName' => self::t('From url')
            ],
            'to_url' => [
                'class' => CharField::class,
                'verboseName' => self::t('To url')
            ],
            'status' => [
                'class' => IntField::class,
                'length' => 3,
                'verboseName' => self::t('Status'),
                'choices' => [
                    '301' => '301',
                    '302' => '302',
                ]
            ]
        ];
    }
}
