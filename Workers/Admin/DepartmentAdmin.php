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
 * @date 13/11/14 10:37
 */
namespace Modules\Workers\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Workers\Forms\DepartmentForm;
use Modules\Workers\Models\Department;
use Modules\Workers\WorkersModule;

class DepartmentAdmin extends ModelAdmin
{
    public $sortingColumn = 'position';

    public function getColumns()
    {
        return ['name'];
    }

    public function getModel()
    {
        return new Department;
    }

    public function getCreateForm()
    {
        return new DepartmentForm();
    }

    public function getNames($model = null)
    {
        return [
            WorkersModule::t('Departments'),
            WorkersModule::t('Create department'),
            WorkersModule::t('Update department'),
        ];
    }
} 