<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 16/01/15 09:25
 */
namespace Modules\Goods\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;

class Image extends Model
{
    public static function getFields() 
    {
        $cls = Mindy::app()->getModule('Goods')->productModel;
        return [
            'file' => [
                'class' => ImageField::className(),
                'sizes' => Mindy::app()->getModule('Goods')->productImageSizes
            ],
            'position' => [
                'class' => IntField::className(),
                'null' => true,
                'default' => 9999
            ],
            'product' => [
                'class' => ForeignField::className(),
                'modelClass' => $cls
            ]
        ];
    }
} 