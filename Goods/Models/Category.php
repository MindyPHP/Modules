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
 * @date 16/01/15 09:04
 */
namespace Modules\Goods\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\AutoSlugField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\TreeModel;
use Modules\Goods\GoodsModule;

class Category extends TreeModel
{
    public static function getFields() 
    {
        $cls = Mindy::app()->getModule('Goods')->productModel;
        return array_merge(parent::getFields(), [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => GoodsModule::t('Name')
            ],
            'url' => [
                'class' => AutoSlugField::className(),
                'verboseName' => GoodsModule::t('Url'),
                'unique' => true
            ],
            'description' => [
                'class' => TextField::className(),
                'null' => true,
                'verboseName' => GoodsModule::t('Description')
            ],
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => GoodsModule::t('Image'),
                'sizes' => Mindy::app()->getModule('Goods')->categoryImageSizes
            ],
            'production' => [
                'class' => HasManyField::className(),
                'modelClass' => $cls,
                'editable' => false
            ]
        ]);
    }
    
    public function __toString() 
    {
        return (string) $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('goods:category', ['url' => $this->url]);
    }
} 