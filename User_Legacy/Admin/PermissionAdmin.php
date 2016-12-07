<?php

namespace Modules\User\Admin;

use Modules\Admin\Admin\Admin;
use Modules\User\Forms\PermissionForm;
use Modules\User\Models\Permission;

/**
 * Class PermissionAdmin
 * @package Modules\User
 */
class PermissionAdmin extends Admin
{
    public $columns = ['code', 'name'];

    public function getCreateForm()
    {
        return PermissionForm::className();
    }

    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Permission::class;
    }
}

