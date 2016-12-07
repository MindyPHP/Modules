<?php

/**
 * User: max
 * Date: 08/10/15
 * Time: 14:51
 */

namespace Modules\Currency\Models;

use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\JsonField;
use Mindy\Orm\Model;
use Modules\Currency\CurrencyModule;

class Currency extends Model
{
    public static function getFields()
    {
        return [
            'created_at' => [
                'class' => DateTimeField::class,
                'verboseName' => CurrencyModule::t('Created at'),
                'autoNowAdd' => true
            ],
            'data' => [
                'class' => JsonField::class,
                'null' => false,
                'verboseName' => CurrencyModule::t('Data')
            ]
        ];
    }

    public function __toString()
    {
        return (string)$this->created_at;
    }

    public static function objectsManager($instance = null)
    {
        $className = get_called_class();
        return new CurrencyManager($instance ? $instance : new $className);
    }
}
