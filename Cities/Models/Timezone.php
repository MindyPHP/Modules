<?php
/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 9:18
 */
namespace Modules\Cities\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Model;
use Modules\Cities\CitiesModule;

class Timezone extends Model
{
    public static function getFields() 
    {
        return [
            'name'=>[
                'class'=> CharField::className(),
                'verboseName'=>CitiesModule::t('Name'),
            ],
            'value'=>[
                'class'=> CharField::className(),
                'verboseName'=>CitiesModule::t('Time zone value'),
            ],
            'delta'=>[
                'class'=>IntField::className(),
                'verboseName'=>CitiesModule::t('Delta time zone')
            ],

        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 