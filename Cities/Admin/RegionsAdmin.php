<?php
/**
 * Created by PhpStorm.
 * User: aleksandrgordeev
 * Date: 26.08.15
 * Time: 9:34
 */
namespace Modules\Cities\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Cities\Models\Region;
use Modules\Cities\CitiesModule;

class RegionsAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name_ru'];
    }
    
    public function getModel()
    {
        return new Region();
    }
    
    public function getNames($model = null)
    {
        return [
            CitiesModule::t('Regions'),
            CitiesModule::t('Create Regions'),
            CitiesModule::t('Update Regions')
        ];
    }
}