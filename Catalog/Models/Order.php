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
 * @date 04/08/14.08.2014 19:53
 */

namespace Modules\Catalog\Models;


use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\DecimalField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Catalog\CatalogModule;
use Modules\User\Models\User;

class Order extends Model
{
    public static function getFields()
    {
        return [
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'verboseName' => CatalogModule::t('Created time')
            ],
            'updated_at' => [
                'class' => DateTimeField::className(),
                'autoNow' => true,
                'verboseName' => CatalogModule::t('Updated time')
            ],
            'user' => [
                'class' => ForeignField::className(),
                'modelClass' => User::className(),
                'null' => true,
                'verboseName' => CatalogModule::t('User')
            ],
            'name' => [
                'class' => CharField::className(),
                'required' => true,
                'verboseName' => CatalogModule::t('Name')
            ],
            'order' => [
                'class' => TextField::className(),
                'null' => false,
                'verboseName' => CatalogModule::t('Order')
            ],
            'price' => [
                'class' => DecimalField::className(),
                'precision' => 10,
                'scale' => 2,
                'verboseName' => CatalogModule::t('Price')
            ],
            'is_complete' => [
                'class' => BooleanField::className(),
                'default' => false,
                'verboseName' => CatalogModule::t('Is complete')
            ]
        ];
    }
}
