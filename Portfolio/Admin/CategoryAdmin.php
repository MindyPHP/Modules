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
 * @date 10/09/14.09.2014 12:26
 */

namespace Modules\Portfolio\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Portfolio\Models\Category;

class CategoryAdmin extends ModelAdmin
{
    public function getSearchFields()
    {
        return ['name'];
    }

    public function getColumns()
    {
        return ['name'];
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Category;
    }
}
