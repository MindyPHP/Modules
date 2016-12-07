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
 * @date 16/01/15 09:02
 */
namespace Modules\Goods;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class GoodsModule extends Module
{
    public $productImageSizes = [];
    public $categoryImageSizes = [];

    public $productModel = '\Modules\Goods\Models\Product';
    public $productForm ='\Modules\Goods\Forms\ProductForm';

    public $categoryModel = '\Modules\Goods\Models\Category';
    public $categoryForm ='\Modules\Goods\Forms\CategoryForm';

    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('goods_categories_tree', ['\Modules\Goods\Helpers\GoodsHelper', 'getCategoriesTree']);
    }

    public function getMenu()
    {
        return [
            'name' => $this->getName(),
            'items' => [
                [
                    'name' => GoodsModule::t('Categories'),
                    'adminClass' => 'CategoryAdmin'
                ],
                [
                    'name' => GoodsModule::t('Products'),
                    'adminClass' => 'ProductAdmin'
                ]
            ]
        ];
    }
}
