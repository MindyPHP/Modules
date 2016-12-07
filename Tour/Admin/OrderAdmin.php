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
 * @date 17/02/15 16:09
 */
namespace Modules\Tour\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Tour\Models\Order;
use Modules\Tour\TourModule;

class OrderAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['organization', 'phone'];
    }
    
    public function getModel()
    {
        return new Order;
    }
    
    public function getNames($model = null)
    {
        return [
            TourModule::t('Orders'),
            TourModule::t('Create Order'),
            TourModule::t('Update Order')
        ];
    }
}