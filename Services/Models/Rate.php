<?php
/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 15/09/14.09.2014 11:58
 */

namespace Modules\Services\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DecimalField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

class Rate extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'verboseName' => self::t('Name')
            ],
            'price' => [
                'class' => DecimalField::class,
                'presicion' => 10,
                'scale' => 2,
                'verboseName' => self::t('Price')
            ],
            'content' => [
                'class' => TextField::class,
                'verboseName' => self::t('Content')
            ],
            'service' => [
                'class' => ForeignField::class,
                'modelClass' => Service::class,
                'verboseName' => self::t('Service')
            ],
        ];
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}
