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
 * @date 16/01/15 09:08
 */
namespace Modules\Goods\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Fields\TreeForeignField;
use Mindy\Orm\Model;
use Modules\Goods\GoodsModule;

class Product extends Model
{
    public static function getFields() 
    {
        $cls = Mindy::app()->getModule('Goods')->categoryModel;
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => GoodsModule::t('Name')
            ],
            'url' => [
                'class' => SlugField::className(),
                'verboseName' => GoodsModule::t('Url'),
                'unique' => true
            ],
            'category' => [
                'class' => TreeForeignField::className(),
                'modelClass' => $cls,
                'verboseName' => GoodsModule::t('Category')
            ],
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => GoodsModule::t('Image'),
                'sizes' => Mindy::app()->getModule('Goods')->productImageSizes
            ],
            'description' => [
                'class' => TextField::className(),
                'verboseName' => GoodsModule::t('Description'),
                'null' => true
            ],
            'images' => [
                'class' => HasManyField::className(),
                'verboseName' => GoodsModule::t('Images'),
                'modelClass' => Image::className()
            ],
            'created_at' => [
                'class' => DateTimeField::className(),
                'autoNowAdd' => true,
                'verboseName' => GoodsModule::t('Created time'),
                'editable' => false,
            ],
            'updated_at' => [
                'class' => DateTimeField::className(),
                'autoNow' => true,
                'verboseName' => GoodsModule::t('Updated time'),
                'editable' => false,
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string) $this->name;
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('goods:product', [$this->url]);
    }
} 