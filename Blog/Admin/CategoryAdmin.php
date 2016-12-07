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
 * @date 29/09/14.09.2014 19:18
 */

namespace Modules\Blog\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Blog\Forms\CategoryForm;
use Modules\Blog\Models\Category;

class CategoryAdmin extends Admin
{
    public $columns = ['name'];

    public function getCreateForm()
    {
        return CategoryForm::className();
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModelClass()
    {
        return Category::class;
    }
}
