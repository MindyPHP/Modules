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
 * @date 19/02/15 06:53
 */
namespace Modules\Vacants\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Vacants\Models\Department;
use Modules\Vacants\VacantsModule;

class DepartmentAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        return new Department;
    }
    
    public function getNames($model = null)
    {
        return [
            VacantsModule::t('Departments'),
            VacantsModule::t('Create Department'),
            VacantsModule::t('Update Department')
        ];
    }
}