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
 * @date 25/02/15 16:20
 */
namespace Modules\Furniture\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;

class Request extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'required' => true
            ],
            'phone' => [
                'class' => CharField::className(),
                'required' => true
            ],
            'furniture' => [
                'class' => ForeignField::className(),
                'modelClass' => Furniture::className()
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string) $this->name . ' ' . $this->phone;
    }
}