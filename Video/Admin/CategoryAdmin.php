<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 24/05/16 09:38
 */

namespace Modules\Video\Admin;

use Modules\Admin\Admin\Admin;
use Modules\Video\Models\Category;

class CategoryAdmin extends Admin
{
    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Category::class;
    }
}