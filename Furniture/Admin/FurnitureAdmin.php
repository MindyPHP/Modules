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
 * @date 24/10/14 09:11
 */
namespace Modules\Furniture\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Furniture\Models\Furniture;

class FurnitureAdmin extends ModelAdmin
{
    public function getColumns()
    {
        return ['name'];
    }

    public function getModel()
    {
        return new Furniture;
    }
}