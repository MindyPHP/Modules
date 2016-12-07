<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 08/06/16
 * Time: 14:18
 */

namespace Modules\Offices\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Offices\Models\Category;

class CategoryAdmin extends Admin
{
    public $columns = ['name', 'position'];

    public $sortingColumn = 'position';

    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Category::class;
    }
}