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
 * @date 17/02/15 15:03
 */
namespace Modules\Tour\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Tour\TourModule;

class Place extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => TourModule::t('Name')
            ],
            'position' => [
                'class' => IntField::className(),
                'editable' => false,
                'default' => 9999,
                'null' => true
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 