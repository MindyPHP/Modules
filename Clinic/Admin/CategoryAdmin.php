<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 27/11/14 15:14
 */

namespace Modules\Clinic\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Clinic\Forms\CategoryForm;
use Modules\Clinic\Models\Category;

class CategoryAdmin extends ModelAdmin
{
    public $sortingColumn = 'position';

    public function getColumns()
    {
        return ['name'];
    }

    /**
     * @return string
     */
    public function getCreateForm()
    {
        return CategoryForm::className();
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Category;
    }
}
