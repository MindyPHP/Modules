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
 * @date 14/11/14.11.2014 15:46
 */

namespace Modules\Geo\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Model;

class Country extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'verboseName' => self::t('Is published')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    public function getAdminNames($instance = null)
    {
        $names = parent::getAdminNames($instance);
        $names[0] = self::t('Countries');
        return $names;
    }
}
