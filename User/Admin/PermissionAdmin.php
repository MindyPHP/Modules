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
    public $columns = ['name', 'code'];

    public $lockField = 'is_locked';

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

