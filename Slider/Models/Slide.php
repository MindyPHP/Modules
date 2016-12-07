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
 * @date 01/09/14.09.2014 13:14
 */

namespace Modules\Slider\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Slider\SliderModule;

class Slide extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => SliderModule::t('Name')
            ],
            'content' => [
                'class' => TextField::className(),
                'verboseName' => SliderModule::t('Content'),
                'null' => true
            ],
            'url' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => SliderModule::t('Url')
            ],
            'image' => [
                'class' => ImageField::className(),
                'sizes' => Mindy::app()->getModule(self::getModuleName())->imageSizes,
                'verboseName' => SliderModule::t('Image')
            ],
            'position' => [
                'class' => IntField::className(),
                'verboseName' => SliderModule::t('Position'),
                'null' => true
            ],
            'is_published' => [
                'class' => BooleanField::className(),
                'default' => true,
                'verboseName' => SliderModule::t('Is published')
            ],
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
