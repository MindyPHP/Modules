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
 * @date 19/02/15 06:43
 */
namespace Modules\Vacants\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\Vacants\VacantsModule;

class Vacancy extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Name of vacancy')
            ],
            'requirements' => [
                'class' => TextField::className(),
                'verboseName' => VacantsModule::t('Requirements')
            ],
            'duties' => [
                'class' => TextField::className(),
                'verboseName' => VacantsModule::t('Duties')
            ],
            'place' => [
                'class' => CharField::className(),
                'verboseName' => VacantsModule::t('Place of work')
            ],
            'department' => [
                'class' => ForeignField::className(),
                'modelClass' => Department::className(),
                'verboseName' => VacantsModule::t('Department')
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 