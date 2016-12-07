<?php

namespace Modules\Nav\Admin;

use Modules\Admin\Components\NestedAdmin;
use Modules\Nav\Forms\NavForm;
use Modules\Nav\NavModule;
use Modules\Nav\Models\Nav;

class NavAdmin extends NestedAdmin
{
    public function getSearchFields()
    {
        return ['name'];
    }

    public function getColumns()
    {
        return ['name', 'slug'];
    }

    public function getCreateForm()
    {
        return NavForm::className();
    }

    public function getModel()
    {
        return new Nav;
    }

    public function getVerboseName()
    {
        return NavModule::t('menu');
    }

    public function getVerboseNamePlural()
    {
        return NavModule::t('menu');
    }
}
