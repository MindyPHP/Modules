<?php

namespace Modules\Redirect\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Redirect\Forms\RedirectForm;
use Modules\Redirect\Models\Redirect;

class RedirectAdmin extends Admin
{
    public $columns = ['from_url', 'to_url', 'type'];

    public function getCreateForm()
    {
        return RedirectForm::className();
    }

    public function getModelClass()
    {
        return Redirect::class;
    }
}

