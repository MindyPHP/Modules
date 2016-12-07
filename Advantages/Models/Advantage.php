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
 * @date 07/11/14 15:25
 */
namespace Modules\Advantages\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Advantages\AdvantagesModule;

class Advantage extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => AdvantagesModule::t('Name')
            ],
            'content' => [
                'class' => TextField::className(),
                'verboseName' => AdvantagesModule::t('Content')
            ],
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => AdvantagesModule::t('Image')
            ],
            'position' => [
                'class' => IntField::className(),
                'verboseName' => AdvantagesModule::t('Position')
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 