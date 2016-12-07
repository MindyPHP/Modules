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
 * @date 03/11/14.11.2014 17:11
 */

namespace Modules\Catalog\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Catalog\Models\Category;

class NavigationHelper
{
    use RenderTrait;

    public static function render()
    {
        return self::renderTemplate("catalog/_navigation.html", [
            'models' => Category::objects()->asTree()->all(),
        ]);
    }
}
