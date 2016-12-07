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

namespace Modules\Forum\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Forum\Models\Forum;

class NavigationHelper
{
    use RenderTrait;

    public static function render()
    {
        $out = self::renderTemplate("forum/_navigation.html", [
            'models' => Forum::objects()->asTree()->all(),
            'nested' => 0
        ]);
        return self::renderTemplate("forum/_navigation_container.html", [
            'out' => $out
        ]);
    }
}
