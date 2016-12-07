<?php
/**
 * 
 *
 * All rights reserved.
 * 
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 15/09/14.09.2014 16:17
 */

namespace Modules\Solutions\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Solutions\Forms\RegionForm;
use Modules\Solutions\Models\Region;
use Modules\Solutions\SolutionsModule;

class RegionAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['id', 'name'];
    }

    public function getModel()
    {
        return new Region;
    }

    public function getCreateForm()
    {
        return new RegionForm();
    }

    public function getVerboseName()
    {
        return SolutionsModule::t('region');
    }

    public function getVerboseNamePlural()
    {
        return SolutionsModule::t('regions');
    }
}
