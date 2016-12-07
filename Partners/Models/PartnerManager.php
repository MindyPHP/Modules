<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 05/01/15 17:30
 */

namespace Modules\Partners\Models;

use Mindy\Orm\Manager;

class PartnerManager extends Manager
{
    public function published()
    {
        $this->filter(['is_published' => true]);
        return $this;
    }
}
