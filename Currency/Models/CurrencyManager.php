<?php

/**
 * User: max
 * Date: 08/10/15
 * Time: 15:05
 */

namespace Modules\Currency\Models;

use Mindy\Orm\Manager;

class CurrencyManager extends Manager
{
    public function latest()
    {
        return $this->order(['-id'])->limit(1)->offset(0);
    }
}
