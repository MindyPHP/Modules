<?php
/**
 * Author: Falaleev Maxim (max107)
 * Email: <max@studio107.ru>
 * Company: Studio107 <http://studio107.ru>
 * Date: 12/05/16 09:36
 */

namespace Modules\Statistics;

use Mindy\Base\Mindy;
use Mindy\Base\Module;
use Modules\Statistics\Library\StatisticsLibrary;

class StatisticsModule extends Module
{
    public static function preConfigure()
    {
        Mindy::app()->template->addLibrary(new StatisticsLibrary);
    }
}