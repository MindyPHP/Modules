<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 28/07/14.07.2014 14:04
 */

namespace Modules\Catalog\Admin;

use Modules\Admin\Components\NestedAdmin;
use Modules\Catalog\Models\Category;

class CategoryAdmin extends NestedAdmin
{
    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Category;
    }

    public function getColumns()
    {
        return ['name'];
    }
}

