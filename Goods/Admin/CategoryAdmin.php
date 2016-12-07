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
use Modules\Admin\Components\NestedAdmin;
use Modules\Goods\GoodsModule;

class CategoryAdmin extends NestedAdmin
{
    public $linkColumn = 'name';

    public function getColumns()
    {
        return ['name'];
    }
    
    public function getModel()
    {
        $cls = Mindy::app()->getModule('Goods')->categoryModel;
        return new $cls;
    }
    
    public function getCreateForm()
    {
        $cls = Mindy::app()->getModule('Goods')->categoryForm;
        return new $cls;
    }
    
    public function getNames($model = null)
    {
        return [
            GoodsModule::t('Categories'),
            GoodsModule::t('Create category'),
            GoodsModule::t('Update category')
        ];
    }
}