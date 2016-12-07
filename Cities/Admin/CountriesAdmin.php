<?php
/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 9:34
 */
namespace Modules\Cities\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Cities\CitiesModule;
use Modules\Cities\Models\Country;

class CountriesAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name_ru'];
    }
    
    public function getModel()
    {
        return new Country();
    }
    
    public function getNames($model = null)
    {
        return [
            CitiesModule::t('Countries'),
            CitiesModule::t('Create country'),
            CitiesModule::t('Update country')
        ];
    }
}