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
 * @date 25/03/15 14:45
 */
namespace Modules\SortableMany;

use Mindy\Base\Mindy;
use Mindy\Base\Module;

class SortableManyModule extends Module
{
    public static function preConfigure()
    {
        $tpl = Mindy::app()->template;
        $tpl->addHelper('sortable_field', ['\Modules\SortableMany\Helpers\SortableHelper', 'sort']);
    }
}
