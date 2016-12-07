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
 * @date 06/11/14 17:27
 */
namespace Modules\Rotator\Helpers;

use Mindy\Utils\RenderTrait;
use Modules\Rotator\Models\Rotator;

class RotatorHelper
{
    use RenderTrait;

    public static function renderRotator()
    {
        $slides = Rotator::objects()->all();

        return self::renderTemplate('rotator/rotator.html', [
            'slides' => $slides
        ]);
    }
}