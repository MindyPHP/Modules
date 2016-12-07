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
 * @date 15/09/14.09.2014 11:53
 */

namespace Modules\Services\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

/**
 * Class Service
 * @package Modules\Services\Models
 */
class Service extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'required' => true,
                'verboseName' => self::t('Name')
            ],
            'description' => [
                'class' => TextField::class,
                'null' => true,
                'verboseName' => self::t('Description')
            ],
            'rate' => [
                'class' => HasManyField::class,
                'modelClass' => Rate::class,
                'editable' => false,
            ],
            'position' => [
                'class' => IntField::class,
                'default' => 0,
                'editable' => false,
                'verboseName' => self::t('Position')
            ]
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('services:view', ['pk' => $this->pk]);
    }
}
