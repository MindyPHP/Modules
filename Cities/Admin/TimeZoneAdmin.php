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
use Modules\Cities\Models\Timezone;

class TimezoneAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new Timezone;
    }
    
    public function getNames($model = null)
    {
        return [
            CitiesModule::t('Time zones'),
            CitiesModule::t('Create time zone'),
            CitiesModule::t('Update time zone')
        ];
    }
}