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
 * @date 06/11/14 16:47
 */
namespace Modules\Rotator\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Rotator\RotatorModule;

class Rotator extends Model
{
    public static function getFields() 
    {
        return [
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => RotatorModule::t('Image')
            ],
            'title' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Title')
            ],
            'description' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Description'),
                'null' => true
            ],
            'action_first' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Action first'),
                'null' => true
            ],
            'action_first_url' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Action first url'),
                'null' => true
            ],
            'action_second' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Action second'),
                'null' => true
            ],
            'action_second_url' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Action second url'),
                'null' => true
            ],
            'name' => [
                'class' => CharField::className(),
                'verboseName' => RotatorModule::t('Name')
            ],
            'thumb_image' => [
                'class' => ImageField::className(),
                'verboseName' => RotatorModule::t('Thumb image')
            ],
            'thumb_image_hover' => [
                'class' => ImageField::className(),
                'verboseName' => RotatorModule::t('Thumb image hover')
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->title;
    }
} 