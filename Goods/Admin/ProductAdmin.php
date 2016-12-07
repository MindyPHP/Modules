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
 * @date 16/01/15 09:55
 */
namespace Modules\Goods\Admin;

use Mindy\Base\Mindy;
use Modules\Admin\Components\ModelAdmin;
use Modules\Goods\Forms\ProductFilterForm;
use Modules\Goods\GoodsModule;

class ProductAdmin extends ModelAdmin
{
    public function getSearchFields()
    {
        return ['category__name'];
    }

    public function getColumns()
    {
        return ['name', 'category'];
    }

    public function getModel()
    {
        $cls = Mindy::app()->getModule('Goods')->productModel;
        return new $cls;
    }
    
    public function getCreateForm()
    {
        $cls = Mindy::app()->getModule('Goods')->productForm;
        return new $cls;
    }

    public function getFilterForm()
    {
        return ProductFilterForm::className();
    }

    public function getNames($model = null)
    {
        return [
            GoodsModule::t('Products'),
            GoodsModule::t('Create product'),
            GoodsModule::t('Update product')
        ];
    }
}