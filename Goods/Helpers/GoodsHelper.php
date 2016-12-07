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
 * @date 19/01/15 08:20
 */
namespace Modules\Goods\Helpers;

use Mindy\Base\Mindy;

class GoodsHelper
{
    public static function getCategoriesTree()
    {
        $cls = Mindy::app()->getModule('Goods')->categoryModel;
        return $cls::tree()->asTree()->all();
    }
}