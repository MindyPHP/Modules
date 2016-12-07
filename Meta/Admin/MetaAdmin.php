<?php

namespace Modules\Meta\Admin;

use Mindy\Base\Mindy;
use Modules\Admin\Admin\Admin;
use Modules\Meta\Forms\MetaForm;
use Modules\Meta\Models\Meta;

class MetaAdmin extends Admin
{
    public $searchFields = ['url', 'title', 'description', 'keywords'];

    public function getColumns()
    {
        $columns = ['title', 'url'];
        if (Mindy::app()->getModule('Meta')->onSite) {
            $columns[] = 'site';
        }
        return $columns;
    }

    public function getModelClass()
    {
        return Meta::class;
    }

    public function getCreateForm()
    {
        return MetaForm::className();
    }
}
