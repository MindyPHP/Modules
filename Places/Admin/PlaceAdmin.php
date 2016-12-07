<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 01/12/14 17:59
 */

namespace Modules\Places\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Places\Forms\PlaceForm;
use Modules\Places\Models\Place;

class PlaceAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name', 'address', 'lat', 'lng', 'phone'];
    }

    public function getCreateForm()
    {
        return PlaceForm::className();
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Place;
    }
}
