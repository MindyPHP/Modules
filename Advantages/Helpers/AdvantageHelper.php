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
 * @date 07/11/14 16:03
 */
namespace Modules\Advantages\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Advantages\Models\Advantage;

class AdvantageHelper
{
    use RenderTrait;

    public static function renderAdvantages($limit = 4)
    {
        $advantages = Advantage::objects()->order(['position'])->limit($limit)->all();

        return self::renderTemplate('advantages/advantages.html', [
            'advantages' => $advantages
        ]);
    }
}