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
 * @date 19/02/15 06:48
 */
namespace Modules\Vacants\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Vacants\VacantsModule;

class Response extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Your name')
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Your phone')
            ],
            'comment' => [
                'class' => TextField::className(),
                'verboseName' => VacantsModule::t('Comment'),
                'null' => true
            ],
            'created_at' => [
                'class' => DatetimeField::className(),
                'verboseName' => VacantsModule::t('Created at'),
                'autoNowAdd' => true,
                'null' => true,
                'editable' => false
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 