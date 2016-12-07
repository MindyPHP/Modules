<?php

namespace Modules\User\Admin;

use Modules\Admin\Admin\Admin;
use Modules\User\Forms\GroupForm;
use Modules\User\Models\Group;

/**
 * Class GroupAdmin
 * @package Modules\User
 */
class GroupAdmin extends Admin
{
    public $columns = ['name', 'is_locked', 'is_visible'];

    public function getCreateForm()
    {
        return GroupForm::class;
    }

    public function getModelClass()
    {
        return Group::class;
    }
}
