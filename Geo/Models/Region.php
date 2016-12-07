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
 * @date 14/11/14.11.2014 15:47
 */

namespace Modules\Geo\Models;

use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;

class Region extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'country' => [
                'class' => ForeignField::class,
                'modelClass' => Country::class,
                'verboseName' => self::t('Country')
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
}
