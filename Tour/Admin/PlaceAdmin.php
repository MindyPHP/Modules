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
 * @date 17/02/15 16:08
 */
namespace Modules\Tour\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Tour\Models\Place;
use Modules\Tour\TourModule;

class PlaceAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new Place;
    }
    
    public function getNames($model = null)
    {
        return [
            TourModule::t('Places'),
            TourModule::t('Create Place'),
            TourModule::t('Update Place')
        ];
    }
}