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
 * @date 15/09/14.09.2014 14:21
 */

namespace Modules\Meta\Models;

use Mindy\Base\Mindy;
use Mindy\Orm\Manager;

class MetaManager extends Manager
{
    public function currentSite()
    {
        $app = Mindy::app();
        if ($app->hasModule('Sites')) {
            $site = $app->getModule('Sites')->getSite();
            $this->filter([
                'site' => $site
            ]);
        }
        return $this;
    }
}
