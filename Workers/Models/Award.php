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
 * @date 13/11/14 10:15
 */
namespace Modules\Workers\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Model;
use Modules\Workers\WorkersModule;

class Award extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Award name')
            ],
            'worker' => [
                'class' => ForeignField::className(),
                'modelClass' => Worker::className(),
                'verboseName' => WorkersModule::t('Worker'),
            ],
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => WorkersModule::t('Image'),
                'sizes' => [
                    'preview' => [
                        186, 186,
                        'method' => 'resize'
                    ]
                ]
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 