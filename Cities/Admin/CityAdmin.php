<?php
/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 9:32
 */
namespace Modules\Cities\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Cities\CitiesModule;
use Modules\Cities\Forms\CityForm;
use Modules\Cities\Models\City;

class CityAdmin extends ModelAdmin
{

    public function getSearchFields(){
        return ['region__name_ru', 'region__country__name_ru', 'name_ru'];
    }

    public function getColumns()
    {
        return ['region__name_ru', 'region__country__name_ru', 'name_ru'];
    }
    
    public function getModel()
    {
        return new City;
    }

    public function getCreateForm(){
        return new CityForm();
    }
    
    public function getNames($model = null)
    {
        return [
            CitiesModule::t('City'),
            CitiesModule::t('Create city'),
            CitiesModule::t('Update city')
        ];
    }
}