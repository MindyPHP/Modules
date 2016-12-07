<?php

namespace Modules\Github\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Github\Models\Repo;

class RepoAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name', 'version', 'published_at'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Repo;
    }
}
