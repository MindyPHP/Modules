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
 * @date 14/09/14.09.2014 13:51
 */

namespace Modules\Faq\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Faq\Forms\CategoryForm;
use Modules\Faq\Models\Category;

class CategoryAdmin extends ModelAdmin
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

    public function getCreateForm()
    {
        return CategoryForm::className();
    }
}