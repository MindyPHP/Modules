<?php
/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 8:58
 */
namespace Modules\Cities\Models;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\FloatField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Model;
use Modules\Cities\CitiesModule;

class City extends Model
{
    protected $_address = null;

    public static function getFields() 
    {
        return [
            'region'=> [
                'class'=>ForeignField::className(),
                'verboseName'=> CitiesModule::t('Region'),
                'modelClass'=>Region::className()
            ],
            'timezone'=>[
                'class'=>ForeignField::className(),
                'verboseName'=> CitiesModule::t('Time zone'),
                'modelClass'=>Timezone::className()
            ],
            'name_ru'=>[
                'class'=> CharField::className(),
                'verboseName'=>CitiesModule::t('Name ru'),
            ],
            'name_en'=>[
                'class'=> CharField::className(),
                'verboseName'=>CitiesModule::t('Name en, optionality'),
                'null'=>true,
            ],
            'lat'=>[
                'class'=>FloatField::className(),
                'verboseName'=>CitiesModule::t('Latitude'),
                'null'=>true,
            ],
            'lng'=>[
                'class'=>FloatField::className(),
                'verboseName'=>CitiesModule::t('Longitude'),
                'null'=>true,
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name_ru;
    }

    public function getAddress(){
        if ($this->_address === null){
            $country = (string)$this->region->country;
            $region = (string)$this->region;
            return "{$country} {$region} {$this->name_ru}";
        }
        return $this->_address;
    }
} 