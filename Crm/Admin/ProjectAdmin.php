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
 * @date 03/10/14 08:52
 */
namespace Modules\Crm\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Crm\Models\Project;

class ProjectAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['id', 'name'];
    }

    public function getModel()
    {
        return new Project;
    }
} 