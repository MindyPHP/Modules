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
 * @date 28/07/14.07.2014 14:50
 */

namespace Modules\Catalog\Admin;

use Modules\Admin\Components\ModelAdmin;
use Modules\Catalog\Forms\ProductForm;
use Modules\Catalog\Models\Product;

class ProductAdmin extends ModelAdmin
{
    public function getCreateForm()
    {
        return ProductForm::className();
    }

    /**
     * @return \Mindy\Orm\Model
     */
    public function getModel()
    {
        return new Product;
    }

    public function getColumns()
    {
        return ['name', 'price'];
    }
}

