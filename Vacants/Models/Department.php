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
 * @date 19/02/15 06:41
 */
namespace Modules\Vacants\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Vacants\VacantsModule;

class Department extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Name'),
            ],
            'position' => [
                'class' => IntField::className(),
                'editable' => false,
                'default' => 9999,
                'null' => true
            ],
            'vacancies' => [
                'class' => HasManyField::className(),
                'editable' => false,
                'modelClass' => Vacancy::className(),
                'verboseName' => VacantsModule::t('Vacancies')
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 