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
 * @date 01/09/14.09.2014 13:41
 */

namespace Modules\Catalog\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Catalog\Models\Category;

class CategoryHelper
{
    use RenderTrait;

    public static function render($template = 'catalog/_categories.html')
    {
        echo self::renderTemplate($template, [
            'models' => Category::tree()->roots()->all()
        ]);
    }
}
