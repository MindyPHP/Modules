<?php
/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 8:58
 */
namespace Modules\Cities\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\Cities\CitiesModule;

class Region extends Model
{
    public static function getFields() 
    {
        return [
            'name_ru'=>[
                'class'=> CharField::className(),
                'verboseName'=>CitiesModule::t('Name ru'),
            ],
            'name_en'=>[
                'class'=> CharField::className(),
                'verboseName'=>CitiesModule::t('Name en, optionality'),
                'null'=>true,
            ],
            'country'=>[
                'class'=>ForeignField::className(),
                'verboseName'=> CitiesModule::t('Country'),
                'modelClass'=>Country::className()
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name_ru;
    }
} 