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
 * @date 25/02/15 17:44
 */
namespace Modules\Furniture\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Furniture\Models\Request;
use Modules\Furniture\FurnitureModule;

class RequestAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name', 'phone'];
    }
    
    public function getModel()
    {
        return new Request;
    }
    
    public function getActionsList()
    {
        return ['info', 'delete'];
    }
}