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
use Modules\Tour\Models\Event;
use Modules\Tour\TourModule;

class EventAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['place', 'datetime'];
    }
    
    public function getModel()
    {
        return new Event;
    }
    
    public function getNames($model = null)
    {
        return [
            TourModule::t('Events'),
            TourModule::t('Create Event'),
            TourModule::t('Update Event')
        ];
    }
}