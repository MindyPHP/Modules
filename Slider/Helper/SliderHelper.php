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

namespace Modules\Slider\Helper;


use Mindy\Utils\RenderTrait;
use Modules\Slider\Models\Slide;

class SliderHelper
{
    use RenderTrait;

    public static function render($template = 'slider/slider.html')
    {
        echo self::renderTemplate($template, [
            'models' => Slide::objects()->filter(['is_published' => true])->order(['position'])->all()
        ]);
    }
}
