<?php

namespace Modules\Sites\Admin;

use Mindy\Base\Mindy;
use Modules\Admin\Admin\Admin;

class SiteAdmin extends Admin
{
    public $columns = ['domain', 'name'];

    public $searchFields = ['name'];

    public function getFormClass()
    {
        $module = Mindy::app()->getModule('Sites');
        return $module->formClass;
    }

    public function getModelClass()
    {
        $module = Mindy::app()->getModule('Sites');
        return $module->modelClass;
    }
}
